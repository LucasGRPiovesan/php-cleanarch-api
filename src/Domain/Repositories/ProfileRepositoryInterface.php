<?php

namespace Domain\Repositories;

use Domain\Entities\Profile;

interface ProfileRepositoryInterface
{
    public function findByUuid(string $uuid): ?Profile;
    public function save(Profile $profile): void;
}
