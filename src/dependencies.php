<?php

// DIC configuration

$container = $app->getContainer();

unset($container['errorHandler']);
unset($container['phpErrorHandler']);
unset($container['notFoundHandler']);

require __DIR__ . '/configuration/templates.php';
require __DIR__ . '/configuration/database.php';
require __DIR__ . '/configuration/mailer.php';
require __DIR__ . '/configuration/logger.php';
require __DIR__ . '/configuration/session.php';
require __DIR__ . '/configuration/protection.php';

return $container;
