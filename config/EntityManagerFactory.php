<?php

namespace Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

class EntityManagerFactory
{
    public static function create(): EntityManager
    {
        // Carrega variáveis de ambiente
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../src/Domain/Entities'],
            isDevMode: true
        );

        $conn = [
            'dbname' => $_ENV['DB_DATABASE'] ?? 'clean_arch',
            'user' => $_ENV['DB_USERNAME'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'host' => $_ENV['DB_HOST'] ?? 'db',
            'port' => $_ENV['DB_PORT'] ?? 3306,
            'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        ];

        return EntityManager::create($conn, $config);
    }
}
