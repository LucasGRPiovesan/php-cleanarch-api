<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTO\FetchProfileDTO;
use Domain\Repositories\ProfileRepositoryInterface;
use RuntimeException;

class FetchProfileUseCase
{
  public function __construct(private ProfileRepositoryInterface $profileRepo){}

  public function execute(string $uuid): FetchProfileDTO
  {
    $profile = $this->profileRepo->fetch($uuid);

    if (!$profile) {
      throw new RuntimeException("Profile not found!");
    }

    return FetchProfileDTO::fromEntity($profile);
  }
}
