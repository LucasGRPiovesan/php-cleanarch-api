<?php

declare(strict_types=1);

namespace Application\UseCases\Store;

use Domain\Entities\Profile;
use Modules\User\Application\DTOs\CreateProfileDTO;
use Domain\Repositories\ProfileRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateProfileUseCase
{
    public function __construct(private ProfileRepositoryInterface $profileRepo){}

    public function execute(CreateProfileDTO $dto): void
    {
        if (empty($dto->profile)) {
            throw new \InvalidArgumentException("Profile name is required.");
        }

        $profile = new Profile(
            Uuid::uuid4()->toString(),
            $dto->profile,
            $dto->description
        );

        $this->profileRepo->save($profile);
    }
}
