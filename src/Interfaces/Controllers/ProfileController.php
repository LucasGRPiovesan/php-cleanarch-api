<?php

namespace Interfaces\Controllers;

use Application\UseCases\List\ListProfileUseCase;
use Application\UseCases\Store\CreateProfileUseCase;
use Frameworks\Web\Routes\Router;
use Infrastructure\Repositories\ProfileRepository;
use Modules\User\Application\DTOs\CreateProfileDTO;

class ProfileController
{
    protected ProfileRepository $profileRepo;
    protected ListProfileUseCase $listProfileUseCase;
    protected CreateProfileUseCase $createProfileUseCase;

    public function __construct($entityManager)
    {
        $this->profileRepo = new ProfileRepository($entityManager);
        $this->listProfileUseCase = new ListProfileUseCase($this->profileRepo);
    }

    public function list(Router $request): void
    {
        try {
            
            $users = $this->listProfileUseCase->execute();
            $request->send(200, $users);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

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
