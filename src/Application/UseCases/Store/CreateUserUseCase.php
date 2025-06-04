<?php

namespace Application\UseCases\Store;

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
        $profile = $this->profileRepo->findByUuid($dto->uuid_profile);
        if (!$profile) {
            throw new \InvalidArgumentException("Profile not found: {$dto->uuid_profile}");
        }

        if (empty($dto->email)) {
            throw new \InvalidArgumentException("Email is required.");
        }

        if (empty($dto->password)) {
            throw new \InvalidArgumentException("Password is required.");
        }

        $user = new User(
            Uuid::uuid4()->toString(),
            $dto->name,
            $dto->email,
            password_hash($dto->password, PASSWORD_DEFAULT),
            $profile
        );

        $this->userRepo->save($user);
    }
}
