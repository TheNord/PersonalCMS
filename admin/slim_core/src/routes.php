<?php

use App\Http\Middleware\AuthMiddleware;

// Routes

$app->get('/', 'App\Http\Controllers\HomeController:home')->setName('home')->add(AuthMiddleware::class);

$app->get('/register', 'App\Http\Controllers\Auth\RegisterController:index')->setName('register.index');
$app->post('/register', 'App\Http\Controllers\Auth\RegisterController:register')->setName('register.store');

$app->get('/login', 'App\Http\Controllers\Auth\LoginController:index')->setName('login.index');
$app->post('/login', 'App\Http\Controllers\Auth\LoginController:login')->setName('login.check');

$app->get('/logout', 'App\Http\Controllers\Auth\LoginController:logout')->setName('logout');
