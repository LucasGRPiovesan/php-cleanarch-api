<?php

namespace Domain\Repositories;

use Domain\Entities\User;

interface UserRepositoryInterface
{
    public function list(): array;
    public function fetch(string $uuid): ?User;
    public function store(User $user): User;
    public function findByEmail(string $email): ?User;
}
