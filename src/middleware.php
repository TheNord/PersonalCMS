<?php

// Application middleware

use App\Http\Middleware;
use Framework\Http\Middleware\ErrorHandlerMiddleware;
use Framework\Http\Middleware\TrailingSlash;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;

$app->add(new Middleware\ProfilerMiddleware());
$app->add(new WhoopsMiddleware($app));
$app->add(new ErrorHandlerMiddleware($container));
$app->add('csrf');
$app->add(new TrailingSlash);

