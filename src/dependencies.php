<?php
// DIC configuration

use Schnittstabil\Psr7\Csrf\MiddlewareBuilder as CsrfMiddlewareBuilder;

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

$container['session'] = function ($c) {
	$session_factory = new \Aura\Session\SessionFactory;
	$session = $session_factory->newInstance($_SESSION);
	$segment = $session->getSegment('slim332rtrggf');

	return $segment;
};

$container['csrf'] = function ($c) {
    $key = 'fdtt435ccxgt346h';

    return CsrfMiddlewareBuilder::create($key)
        ->buildSynchronizerTokenPatternMiddleware();
};

return $container;
