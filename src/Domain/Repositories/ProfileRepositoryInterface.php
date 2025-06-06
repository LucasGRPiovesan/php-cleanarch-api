<?php

namespace Domain\Repositories;

use Domain\Entities\Profile;

interface ProfileRepositoryInterface
{
    public function list(): array;
    public function fetch(string $uuid): ?Profile;
    public function store(Profile $profile): Profile;
    public function update(Profile $profile): Profile;
    public function delete(Profile $profile): void;
}
