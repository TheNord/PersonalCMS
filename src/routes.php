<?php

use App\Http\Controllers;

// Routes

$app->get('/', Controllers\HomeController::class . ':home')->setName('home');
$app->get('/about', Controllers\HomeController::class . ':about')->setName('about');

$app->get('/cabinet', Controllers\CabinetController::class . ':index')->setName('cabinet');

$app->get('/blog', Controllers\Blog\BlogController::class . ':index')->setName('blog');
$app->get('/blog/page/{page}', Controllers\Blog\BlogController::class . ':index', ['tokens' => ['page' => '\d+']])->setName('blog_page');
$app->get('/blog/{id}', Controllers\Blog\BlogController::class . ':show', ['tokens' => ['id' => '\d+']])->setName('blog_show');

$app->get('/contact', Controllers\ContactController::class . ':index')->setName('contact');
$app->post('/contact', Controllers\ContactController::class . ':send')->setName('contact_send');