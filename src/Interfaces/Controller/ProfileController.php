<?php

namespace Infra\Controllers;

use Application\UseCases\CreateProfileUseCase;
use Modules\User\Application\DTOs\CreateProfileDTO;

class ProfileController
{
    public function __construct(private CreateProfileUseCase $createProfileUseCase)
    {
    }

    /**
     * Recebe os dados da requisição para criar um novo usuário.
     * @param array $request Dados de entrada (ex: $_POST)
     * @return void
     * @throws \InvalidArgumentException Caso dados inválidos
     */
    public function store(array $request): void
    {
        $dto = CreateProfileDTO::fromArray($request);

        $this->createProfileUseCase->execute($dto);

        echo "Perfil criado com sucesso!";
    }
}
