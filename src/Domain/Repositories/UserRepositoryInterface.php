<?php

namespace Domain\Repositories;

use Domain\Entities\User;

interface UserRepositoryInterface
{
    public function list(): array;
    public function save(User $user): void;
    public function findByEmail(string $email): ?User;
}
