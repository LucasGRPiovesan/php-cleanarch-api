<?php

namespace Modules\User\Application\DTOs;

class CreateProfileDTO
{
    public string $profile;
    public ?string $description;

    public function __construct(string $profile, ?string $description = null)
    {
        $this->profile = $profile;
        $this->description = $description;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['profile'],
            $data['description'] ?? null
        );
    }
}
