<?php

use Config\EntityManagerFactory;
use Interfaces\Controllers\ProfileController;

$entityManager = EntityManagerFactory::create();
$profileController = new ProfileController($entityManager);

$router->get('/profiles/list', [$profileController, 'list']);
