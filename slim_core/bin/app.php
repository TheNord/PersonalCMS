#!/usr/bin/env php
<?php
declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$settings = require 'src/settings.php';
$app = new \Slim\App($settings);
/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'src/container.php';

$cli = new Application('Application console');

$entityManager = $container->get(EntityManager::class);
$connection = $entityManager->getConnection();

$configuration = new \Doctrine\Migrations\Configuration\Configuration($connection);

$configuration->setMigrationsDirectory('db/migrations');
$configuration->setMigrationsNamespace('Db\Migrations');

$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');
$cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');

Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);
Doctrine\Migrations\Tools\Console\ConsoleRunner::addCommands($cli);

$commands = $container->get('settings')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->addCommands([
    new \App\Console\Command\FixtureCommand(
        $container->get(EntityManager::class),
        'db/fixtures'
    ),
]);

$cli->run();