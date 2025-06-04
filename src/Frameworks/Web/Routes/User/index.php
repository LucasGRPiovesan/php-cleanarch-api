<?php

use Config\EntityManagerFactory;
use Interfaces\Controllers\UserController;

$entityManager = EntityManagerFactory::create();
$userController = new UserController($entityManager);

$router->get('/users/list', [$userController, 'list']);
