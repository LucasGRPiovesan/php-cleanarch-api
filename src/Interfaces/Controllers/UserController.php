<?php

namespace Interfaces\Controllers;

use Application\DTO\CreateUserDTO;
use Application\UseCases\Store\CreateUserUseCase;
use Application\UseCases\List\ListUserUseCase;

use Frameworks\Web\Routes\Router;
use Infrastructure\Repositories\ProfileRepository;
use Infrastructure\Repositories\UserRepository;

class UserController
{
    protected UserRepository $userRepo;
    protected ProfileRepository $profileRepo;
    
    protected ListUserUseCase $listUserUseCase;
    protected CreateUserUseCase $createUserUseCase;

    public function __construct($entityManager)
    {
        $this->userRepo = new UserRepository($entityManager);
        $this->profileRepo = new ProfileRepository($entityManager);
        $this->listUserUseCase = new ListUserUseCase($this->userRepo);
        $this->createUserUseCase = new CreateUserUseCase($this->userRepo, $this->profileRepo);
    }

    public function list(Router $request): void
    {
        try {
            
            $users = $this->listUserUseCase->execute();
            $request->send(200, $users);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Receives the request data to create a new user.
     * @param Router $request Input data (ex: $_POST)
     * @return void
     * @throws \InvalidArgumentException Invalid input
     */
    public function store(Router $request): void
    {
        try {

            $dto = CreateUserDTO::fromArray($request->payload);
            $this->createUserUseCase->execute($dto);

        } catch (\InvalidArgumentException $e) {

            $request->send(400, ['error' => $e->getMessage()]);

        } catch (\Exception $e) {

            $request->send(500, ['error' => 'Internal server error']);
        }
    }
}
