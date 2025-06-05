<?php

namespace Application\UseCases;

use Application\DTO\ListProfileDTO;
use Domain\Repositories\ProfileRepositoryInterface;

class ListProfileUseCase
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepo,
    ) {}

    /**
     * @return ListProfileDTO[]
     */
    public function execute(): array
    {
        $users = $this->profileRepo->list();
        return ListProfileDTO::fromMany($users);
    }
}
