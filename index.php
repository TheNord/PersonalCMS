<?php
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/slim_core/vendor/autoload.php';

session_start();

// Instantiate the app
$container = require __DIR__ . '/slim_core/src/container.php';
$app = new \Slim\App($container);

// Set up dependencies
require __DIR__ . '/slim_core/src/dependencies.php';

// Register global middleware
require __DIR__ . '/slim_core/src/middleware.php';

// Register routes
require __DIR__ . '/slim_core/src/routes.php';

// Run app
$app->run();
