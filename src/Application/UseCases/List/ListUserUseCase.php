<?php

namespace Application\UseCases\List;

use Application\DTO\List\ListUserDTO;
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
