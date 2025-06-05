<?php

namespace Application\DTO;

use Domain\Entities\{Profile, User};

class FetchUserDTO
{
    public string $uuid;
    public string $name;
    public string $email;
    public array $profile;
    public string $created_at;

    public function __construct(
      string $uuid,
      string $name,
      string $email,
      Profile $profile,
      string $created_at
    ) {
      $this->uuid = $uuid;
      $this->name = $name;
      $this->email = $email;
      $this->profile = [
        "uuid" => $profile->getUuid(),
        "profile" => $profile->getProfile(),
      ];
      $this->created_at = $created_at;
    }

  public static function fromEntity(User $user): self
  {
    return new self(
      $user->getUuid(),
      $user->getName(),
      $user->getEmail(),
      $user->getProfile(),
      $user->getCreatedAt()->format('Y-m-d H:i:s')
    );
  }
}
