<?php

namespace Application\DTO\List;

use Domain\Entities\Profile;

class ListProfileDTO
{
    public string $uuid;
    public string $profile;
    public string $description;
    public string $created_at;

    public function __construct(
        string $uuid,
        string $profile,
        string $description,
        string $created_at
    ) {
        $this->uuid = $uuid;
        $this->profile = $profile;
        $this->description = $description;
        $this->created_at = $created_at;
    }

    public static function fromEntity(Profile $profile): self
    {
        return new self(
            $profile->getUuid(),
            $profile->getProfile(),
            $profile->getDescription(),
            $profile->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public static function fromMany(array $profiles): array
    {
        return array_map(fn(Profile $profile) => self::fromEntity($profile), $profiles);
    }
}
