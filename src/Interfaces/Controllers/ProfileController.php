<?php

namespace Interfaces\Controllers;

use Config\EntityManagerFactory;
use Application\UseCases\{DeleteProfileUseCase, ListProfileUseCase, FetchProfileUseCase, StoreProfileUseCase, UpdateProfileUseCase};
use Frameworks\Web\Routes\Router;
use Infrastructure\Repositories\ProfileRepository;
use Application\DTO\StoreProfileDTO;
use Application\DTO\UpdateProfileDTO;

class ProfileController
{
    protected $entityManager;
    protected ProfileRepository $profileRepo;
    protected ListProfileUseCase $listProfileUseCase;
    protected FetchProfileUseCase $fetchProfileUseCase;
    protected StoreProfileUseCase $storeProfileUseCase;
    protected UpdateProfileUseCase $updateProfileUseCase;
    protected DeleteProfileUseCase $deleteProfileUseCase;

    public function __construct()
    {
        $this->entityManager = EntityManagerFactory::create();
        
        $this->profileRepo = new ProfileRepository($this->entityManager);
        $this->listProfileUseCase = new ListProfileUseCase($this->profileRepo);
        $this->fetchProfileUseCase = new FetchProfileUseCase($this->profileRepo);
        $this->storeProfileUseCase = new StoreProfileUseCase($this->profileRepo);
        $this->updateProfileUseCase = new UpdateProfileUseCase($this->profileRepo);
        $this->deleteProfileUseCase = new DeleteProfileUseCase($this->profileRepo);
    }

    public function list(Router $request): void
    {
        try {
            
            $profiles = $this->listProfileUseCase->execute();
            $request->send(200, $profiles);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

    public function fetch(Router $request): void 
    {
        try {

            $uuid = $request->queryParams['uuid'];
            
            $profile = $this->fetchProfileUseCase->execute($uuid);
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

            $data = StoreProfileDTO::fromArray($request->payload);
            
            $profile = $this->storeProfileUseCase->execute($data);
            $request->send(200, $profile);

        } catch (\InvalidArgumentException $e) {
        
            $request->send(400, ['error' => $e->getMessage()]);
        
        } catch (\RuntimeException $e) {

            $request->send(404, ['message' => $e->getMessage()]);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Router $request): void 
    {
        try {

            $uuid = $request->queryParams['uuid'];
            $dto = UpdateProfileDTO::fromArray($request->payload);
            
            $profile = $this->updateProfileUseCase->execute($uuid, $dto);
            $request->send(200, $profile);

        } catch (\InvalidArgumentException $e) {
        
            $request->send(400, ['error' => $e->getMessage()]);
        
        } catch (\RuntimeException $e) {

            $request->send(404, ['message' => $e->getMessage()]);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }

    public function delete(Router $request): void 
    {
        try {

            $uuid = $request->queryParams['uuid'];
            
            $this->deleteProfileUseCase->execute($uuid);
            $request->send(200, ['sucess' => 'Profile deleted successfully']);

        } catch (\InvalidArgumentException $e) {
        
            $request->send(400, ['error' => $e->getMessage()]);
        
        } catch (\RuntimeException $e) {

            $request->send(404, ['message' => $e->getMessage()]);

        } catch (\Exception $e) {
            
            $request->send(500, ['error' => $e->getMessage()]);
        }
    }
}
