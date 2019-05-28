<?php

use App\Http\Middleware\AuthMiddleware;

// Auth routes
$app->get('/register', 'App\Http\Controllers\Auth\RegisterController:index')->setName('register.index');
$app->post('/register', 'App\Http\Controllers\Auth\RegisterController:register')->setName('register.store');

$app->get('/login', 'App\Http\Controllers\Auth\LoginController:index')->setName('login.index');
$app->post('/login', 'App\Http\Controllers\Auth\LoginController:login')->setName('login.check');

$app->post('/logout', 'App\Http\Controllers\Auth\LoginController:logout')->setName('logout');

$app->group('/utils', function () use ($app) {
    $app->get('/date', function ($request, $response) {
        return $response->getBody()->write(date('Y-m-d H:i:s'));
    });
    $app->get('/time', function ($request, $response) {
        return $response->getBody()->write(time());
    });
});

$app->group('', function () use ($app) {
    $app->get('/', 'App\Http\Controllers\DashboardController:dashboard')->setName('dashboard')->add(AuthMiddleware::class);
    $app->get('/pages', 'App\Http\Controllers\PageController:index')->setName('pages');
    $app->get('/pages/home', 'App\Http\Controllers\PageController:editHome')->setName('pages.home');
})->add(AuthMiddleware::class);
