<?php

use Config\EntityManagerFactory;
use Interfaces\Controllers\ProfileController;

$entityManager = EntityManagerFactory::create();
$profileController = new ProfileController($entityManager);

$router->get('/profiles', [$profileController, 'list']);
$router->get('/profile/{uuid}', [$profileController, 'fetch']);
$router->post('/profile', [$profileController, 'store']);
