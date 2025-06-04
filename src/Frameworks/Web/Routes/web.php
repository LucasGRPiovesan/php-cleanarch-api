<?php

use Frameworks\Web\Routes\Router;

$router = new Router();

require_once __DIR__ . '/../../../../src/Frameworks/Web/Routes/User/index.php';
require_once __DIR__ . '/../../../../src/Frameworks/Web/Routes/Profile/index.php';

$router->dispatch();

