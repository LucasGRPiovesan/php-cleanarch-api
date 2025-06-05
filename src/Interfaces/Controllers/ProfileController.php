<?php

namespace Interfaces\Controllers;

use Application\UseCases\{ListProfileUseCase, FetchProfileUseCase, StoreProfileUseCase};
use Frameworks\Web\Routes\Router;
use Infrastructure\Repositories\ProfileRepository;
use Application\DTO\StoreProfileDTO;

class ProfileController
{
    protected ProfileRepository $profileRepo;
    protected ListProfileUseCase $listProfileUseCase;
    protected FetchProfileUseCase $fetchProfileUseCase;
    protected StoreProfileUseCase $storeProfileUseCase;

    public function __construct($entityManager)
    {
        $this->profileRepo = new ProfileRepository($entityManager);
        $this->listProfileUseCase = new ListProfileUseCase($this->profileRepo);
        $this->fetchProfileUseCase = new FetchProfileUseCase($this->profileRepo);
        $this->storeProfileUseCase = new StoreProfileUseCase($this->profileRepo);
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
}
