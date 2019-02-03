<?php
// DIC configuration



$container = $app->getContainer();

unset($container['errorHandler']);
unset($container['phpErrorHandler']);
unset($container['notFoundHandler']);

require __DIR__ . '/configuration/templates.php';
require __DIR__ . '/configuration/database.php';

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

return $container;
