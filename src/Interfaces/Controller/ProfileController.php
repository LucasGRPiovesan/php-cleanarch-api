<?php

namespace Infra\Controllers;

use Application\UseCases\CreateProfileUseCase;
use Modules\User\Application\DTOs\CreateProfileDTO;

class ProfileController
{
    public function __construct(private CreateProfileUseCase $createProfileUseCase){}

    /**
     * Receives the request data to create a new profile.
     * @param array $request Input data (ex: $_POST)
     * @return void
     * @throws \InvalidArgumentException Invalid input
     */
    public function store(array $request): void
    {
        $dto = CreateProfileDTO::fromArray($request);

        $this->createProfileUseCase->execute($dto);

        echo "Profile created successfully!";
    }
}
