<?php

require 'vendor/autoload.php';

use App\Config;
use Dotenv\Dotenv;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new PhpFile('migrations.php');

$databaseConfig = (new Config($_ENV))->db;

$entityManager = EntityManager::create(
    $databaseConfig,
    ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/App/Entities'])
);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
