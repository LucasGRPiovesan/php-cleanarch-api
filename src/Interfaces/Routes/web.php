<?php

use Infra\Controllers\UserController;
use Application\UseCases\CreateUserUseCase;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Repositories\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

// Supondo que você tenha o EntityManager configurado
/** @var EntityManagerInterface $entityManager */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/users' && $method === 'POST') {
    // Instancia os repositórios
    $userRepo = new UserRepository($entityManager);
    $profileRepo = new ProfileRepository($entityManager);

    // Instancia o Use Case
    $createUserUseCase = new CreateUserUseCase($userRepo, $profileRepo);

    // Instancia o Controller com o Use Case
    $controller = new UserController($createUserUseCase);

    // Captura os dados enviados (form-data, json etc)
    // Aqui supomos JSON na request body
    $requestBody = file_get_contents('php://input');
    $requestData = json_decode($requestBody, true);

    try {
        $controller->store($requestData);
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno no servidor']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);
}
