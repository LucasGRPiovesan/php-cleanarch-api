<?php

namespace Application\UseCases;

use Application\DTO\CreateUserDTO;
use Domain\Entities\User;
use Domain\Repositories\ProfileRepositoryInterface;
use Domain\Repositories\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private ProfileRepositoryInterface $profileRepo
    ) {}

    public function execute(CreateUserDTO $dto): void
    {
        // 1. Busca o perfil pelo UUID
        $profile = $this->profileRepo->findByUuid($dto->uuid_profile);

        if (!$profile) {
            throw new \InvalidArgumentException("Perfil não encontrado para o UUID: {$dto->uuid_profile}");
        }

        // 2. Validação simples (exemplo: email não vazio)
        if (empty($dto->email)) {
            throw new \InvalidArgumentException("Email é obrigatório.");
        }

        if (empty($dto->password)) {
            throw new \InvalidArgumentException("Senha é obrigatória.");
        }

        // 3. Cria a entidade User (gera UUID para o usuário)
        $user = new User(
            Uuid::uuid4()->toString(),
            $dto->name,
            $dto->email,
            password_hash($dto->password, PASSWORD_DEFAULT),
            $profile
        );

        // 4. Persiste o usuário no banco
        $this->userRepo->save($user);
    }
}
