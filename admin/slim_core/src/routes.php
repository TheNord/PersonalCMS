<?php

use App\Http\Controllers;
use App\Http\Middleware\AuthMiddleware;

// Routes

$app->get('/', Controllers\HomeController::class . ':home')->setName('home');
$app->get('/about', Controllers\HomeController::class . ':about')->setName('about');

$app->get('/cabinet', Controllers\CabinetController::class . ':index')->setName('cabinet.index')->add(AuthMiddleware::class);

$app->get('/blog', Controllers\Blog\BlogController::class . ':index')->setName('blog');
$app->get('/blog/page/{page}', Controllers\Blog\BlogController::class . ':index', ['tokens' => ['page' => '\d+']])->setName('blog_page');
$app->get('/blog/{id}', Controllers\Blog\BlogController::class . ':show', ['tokens' => ['id' => '\d+']])->setName('blog_show');

$app->get('/contact', Controllers\ContactController::class . ':index')->setName('contact');
$app->post('/contact', Controllers\ContactController::class . ':send')->setName('contact_send');

$app->get('/register', Controllers\Auth\RegisterController::class . ':index')->setName('register.index');
$app->post('/register', Controllers\Auth\RegisterController::class . ':register')->setName('register.store');
$app->get('/register/activate/{token}', Controllers\Auth\RegisterController::class . ':activate')->setName('register.activate');

$app->get('/login', Controllers\Auth\LoginController::class . ':index')->setName('login.index');
$app->post('/login', Controllers\Auth\LoginController::class . ':login')->setName('login.check');

$app->get('/logout', Controllers\Auth\LoginController::class . ':logout')->setName('logout');
