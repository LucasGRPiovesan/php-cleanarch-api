<?php

namespace Infra\Controllers;

use Application\DTO\CreateUserDTO;
use Application\UseCases\CreateUserUseCase;

class UserController
{
    public function __construct(private CreateUserUseCase $createUserUseCase) {}

    /**
     * Receives the request data to create a new user.
     * @param array $request Input data (ex: $_POST)
     * @return void
     * @throws \InvalidArgumentException Invalid input
     */
    public function store(array $request): void
    {
        $dto = CreateUserDTO::fromArray($request);
        $this->createUserUseCase->execute($dto);

        echo "User created successfully!";
    }
}
