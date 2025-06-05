<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTO\FetchUserDTO;
use Domain\Repositories\UserRepositoryInterface;
use RuntimeException;

class FetchUserUseCase
{
  public function __construct(private UserRepositoryInterface $userRepo){}

  public function execute(string $uuid): FetchUserDTO
  {
    $profile = $this->userRepo->fetch($uuid);

    if (!$profile) {
      throw new RuntimeException("User not found!");
    }

    return FetchUserDTO::fromEntity($profile);
  }
}
