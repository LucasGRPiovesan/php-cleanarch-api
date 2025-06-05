<?php

namespace Application\UseCases;

use Application\DTO\ListUserDTO;
use Domain\Repositories\UserRepositoryInterface;

class ListUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
    ) {}

    /**
     * @return ListUserDTO[]
     */
    public function execute(): array
    {
        $users = $this->userRepo->list();
        return ListUserDTO::fromMany($users);
    }
}
