<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

// Roda o roteador
require_once __DIR__ . '/../src/Frameworks/Web/Routes/web.php';
