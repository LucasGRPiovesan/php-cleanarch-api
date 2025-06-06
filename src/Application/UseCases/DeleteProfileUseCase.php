<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Repositories\ProfileRepositoryInterface;
use RuntimeException;

class DeleteProfileUseCase
{
  public function __construct(private ProfileRepositoryInterface $profileRepo){}

  public function execute(string $uuid): void
  {
    $profile = $this->profileRepo->fetch($uuid);

    if (!$profile) {
      throw new RuntimeException("Profile not found!");
    }

    $this->profileRepo->delete($profile);
  }
}
