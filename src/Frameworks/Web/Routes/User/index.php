<?php

use Config\EntityManagerFactory;
use Interfaces\Controllers\UserController;

$entityManager = EntityManagerFactory::create();
$userController = new UserController($entityManager);

$router->get('/users', [$userController, 'list']);
$router->get('/user/{uuid}', [$userController, 'fetch']);
$router->post('/user', [$userController, 'store']);
$router->patch('/user/{uuid}', [$userController, 'update']);
$router->delete('/user/{uuid}', [$userController, 'delete']);
