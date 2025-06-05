<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\Entities\Profile;
use Domain\Repositories\ProfileRepositoryInterface;
use Application\DTO\{FetchProfileDTO, StoreProfileDTO};
use Ramsey\Uuid\Uuid;

class StoreProfileUseCase
{
  public function __construct(private ProfileRepositoryInterface $profileRepo){}

  public function execute(StoreProfileDTO $data): FetchProfileDTO
  {
    $profile = $this->profileRepo->store(new Profile(
      Uuid::uuid4()->toString(),
      $data->profile,
      $data->description
    ));

    return FetchProfileDTO::fromEntity($profile);
  }
}
