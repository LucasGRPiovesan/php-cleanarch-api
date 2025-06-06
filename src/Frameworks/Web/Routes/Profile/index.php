<?php

use Interfaces\Controllers\ProfileController;

$profileController = new ProfileController();

$router->get('/profiles', [$profileController, 'list']);
$router->get('/profile/{uuid}', [$profileController, 'fetch']);
$router->post('/profile', [$profileController, 'store']);
$router->patch('/profile/{uuid}', [$profileController, 'update']);
$router->delete('/profile/{uuid}', [$profileController, 'delete']);
