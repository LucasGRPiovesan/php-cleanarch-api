<?php

namespace Infra\Controllers;

use Application\DTO\CreateUserDTO;
use Application\UseCases\CreateUserUseCase;

class UserController
{
    public function __construct(private CreateUserUseCase $createUserUseCase)
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
        // Cria o DTO a partir do array recebido
        $dto = CreateUserDTO::fromArray($request);

        // Executa o caso de uso (Use Case)
        $this->createUserUseCase->execute($dto);

        // Resposta simples (pode ser JSON, redirect, etc)
        echo "Usuário criado com sucesso!";
    }
}
