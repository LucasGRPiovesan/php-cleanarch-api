<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTO\{FetchUserDTO, UpdateUserDTO};
use Domain\Repositories\{UserRepositoryInterface, ProfileRepositoryInterface};
use RuntimeException;

class UpdateUserUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepo,
    private ProfileRepositoryInterface $profileRepo
  ){}

  public function execute(string $uuid, UpdateUserDTO $dto): FetchUserDTO
  {
    $updates = $dto->getFields();

    $profile = null;
    if (isset($updates['uuid_profile'])) {
      $profile = $this->profileRepo->fetch($updates['uuid_profile']);
      if (!$profile) {
        throw new RuntimeException("Profile not found!");
      }
    }

    $user = $this->userRepo->fetch($uuid);
    $dto->applyTo($user, $profile);
    $this->userRepo->update($user);

    return FetchUserDTO::fromEntity($user);
  }
}
