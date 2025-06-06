<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Entities\User;
use Application\DTO\{FetchUserDTO, StoreUserDTO};
use Domain\Repositories\{UserRepositoryInterface, ProfileRepositoryInterface};
use Ramsey\Uuid\Uuid;
use RuntimeException;

class StoreUserUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepo,
    private ProfileRepositoryInterface $profileRepo
  ){}

  public function execute(StoreUserDTO $data): FetchUserDTO
  {
    $profile = $this->profileRepo->fetch($data->uuid_profile);

    if (!$profile) {
      throw new RuntimeException("Profile not found!");
    }

    $user = $this->userRepo->store(new User(
      Uuid::uuid4()->toString(),
      $data->name,
      $data->email,
      $data->password,
      $profile
    ));

    return FetchUserDTO::fromEntity($user);
  }
}
