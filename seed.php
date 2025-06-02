<?php

require_once 'vendor/autoload.php';

use Config\EntityManagerFactory;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Infrastructure\Database\Seeds\{ProfileFixture, UserFixture};

$entityManager = EntityManagerFactory::create();

$loader = new Loader();
$loader->addFixture(new ProfileFixture());
$loader->addFixture(new UserFixture());

$purger = new ORMPurger();

$executor = new ORMExecutor($entityManager, $purger);
$executor->execute($loader->getFixtures());

