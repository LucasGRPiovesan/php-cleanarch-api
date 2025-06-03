<?php

use Infra\Controllers\UserController;
use Application\UseCases\CreateUserUseCase;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Repositories\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @var EntityManagerInterface $entityManager */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/users' && $method === 'POST') {

    $userRepo = new UserRepository($entityManager);
    $profileRepo = new ProfileRepository($entityManager);

    $createUserUseCase = new CreateUserUseCase($userRepo, $profileRepo);

    $controller = new UserController($createUserUseCase);

    $requestBody = file_get_contents('php://input');
    $requestData = json_decode($requestBody, true);

    try {

        $controller->store($requestData);

    } catch (\InvalidArgumentException $e) {

        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);

    } catch (\Exception $e) {

        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
