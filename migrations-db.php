<?php

use Dotenv\Dotenv;

// Carrega variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

return [
    'dbname' => $_ENV['DB_DATABASE'] ?? 'clean_arch',
    'user' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? 'root',
    'host' => $_ENV['DB_HOST'] ?? 'db',
    'port' => $_ENV['DB_PORT'] ?? 3306,
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];