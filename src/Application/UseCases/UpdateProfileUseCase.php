<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Repositories\ProfileRepositoryInterface;
use Application\DTO\{FetchProfileDTO, UpdateProfileDTO};
use RuntimeException;

class UpdateProfileUseCase
{
  public function __construct(private ProfileRepositoryInterface $profileRepo){}

  public function execute(string $uuid, UpdateProfileDTO $dto): FetchProfileDTO
  {
    $profile = $this->profileRepo->fetch($uuid);

    if (!$profile) {
      throw new RuntimeException("Profile not found!");
    }

    $dto->applyTo($profile);
    $this->profileRepo->update($profile);

    return FetchProfileDTO::fromEntity($profile);
  }
}
