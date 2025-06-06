<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Repositories\UserRepositoryInterface;
use RuntimeException;

class DeleteUserUseCase
{
  public function __construct(private UserRepositoryInterface $userRepo){}

  public function execute(string $uuid): void
  {
    $user = $this->userRepo->fetch($uuid);

    if (!$user) {
      throw new RuntimeException("User not found!");
    }

    $this->userRepo->delete($user);
  }
}
