<?php

# windows: php vendor/doctrine/orm/bin/doctrine
# unix: php vendor/bin/doctrine

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

/** @var Container $container */
$container = require_once __DIR__ . '/src/dependencies.php';

$cli = ConsoleRunner::createApplication(ConsoleRunner::createHelperSet($container[EntityManager::class]));

$cli->addCommands([
    new \App\Console\Command\FixtureCommand(
        $container->get(EntityManager::class),
        'db/fixtures'
    ),
]);


$cli->run();