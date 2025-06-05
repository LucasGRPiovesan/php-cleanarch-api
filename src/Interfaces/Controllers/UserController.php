<?php

namespace Interfaces\Controllers;

use Application\DTO\StoreUserDTO;
use Application\UseCases\{ListUserUseCase, FetchUserUseCase, StoreUserUseCase};

use Frameworks\Web\Routes\Router;
use Infrastructure\Repositories\ProfileRepository;
use Infrastructure\Repositories\UserRepository;

class UserController
{
    protected UserRepository $userRepo;
    protected ProfileRepository $profileRepo;
    
    protected ListUserUseCase $listUserUseCase;
    protected FetchUserUseCase $fetchUserUseCase;
    protected StoreUserUseCase $storeUserUseCase;

    public function __construct($entityManager)
    {
        $this->userRepo = new UserRepository($entityManager);
        $this->profileRepo = new ProfileRepository($entityManager);
        $this->listUserUseCase = new ListUserUseCase($this->userRepo);
        $this->fetchUserUseCase = new FetchUserUseCase($this->userRepo);
        $this->storeUserUseCase = new StoreUserUseCase($this->userRepo, $this->profileRepo);
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

    public function fetch(Router $request): void
    {
        try {

            $uuid = $request->queryParams['uuid'];
            
            $profile = $this->fetchUserUseCase->execute($uuid);
            $request->send(200, $profile);

        } catch (\RuntimeException $e) {

            $request->send(404, ['message' => $e->getMessage()]);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

    public function store(Router $request): void 
    {
        try {

            $data = StoreUserDTO::fromArray($request->payload);
            
            $profile = $this->storeUserUseCase->execute($data);
            $request->send(200, $profile);

        } catch (\InvalidArgumentException $e) {
        
            $request->send(400, ['error' => $e->getMessage()]);
        
        } catch (\RuntimeException $e) {

            $request->send(404, ['message' => $e->getMessage()]);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }
}
