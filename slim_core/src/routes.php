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

// Admin group routes
$app->group('/admin', function () use ($app) {
    $app->get('', 'App\Http\Controllers\DashboardController:dashboard')->setName('dashboard')->add(AuthMiddleware::class);

    // Pages routes
    $app->get('/pages', 'App\Http\Controllers\PageController:index')->setName('pages');
    $app->get('/pages/{page}/edit', 'App\Http\Controllers\PageController:edit')->setName('pages.edit');
    $app->get('/pages/{page}/edit/start', 'App\Http\Controllers\PageController:editStart')->setName('pages.edit.start');

    $app->post('/pages/edit/save', 'App\Http\Controllers\PageController:store');

    // Contact form routes
    $app->get('/contacts', 'App\Http\Controllers\Admin\ContactController:index')->setName('admin.contacts');
    $app->post('/contacts/{id}/destroy', 'App\Http\Controllers\Admin\ContactController:destroy')->setName('admin.contacts.destroy');

    // Site settings
    $app->get('/settings', 'App\Http\Controllers\Admin\SettingsController:index')->setName('admin.settings');

    $app->get('/settings/robots', 'App\Http\Controllers\Admin\SettingsController:robots')->setName('admin.settings.robots');
    $app->post('/settings/robots', 'App\Http\Controllers\Admin\SettingsController:robotsUpdate')->setName('admin.settings.robots.update');

    $app->get('/settings/project', 'App\Http\Controllers\Admin\SettingsController:project')->setName('admin.settings.project');
    $app->post('/settings/project', 'App\Http\Controllers\Admin\SettingsController:projectUpdate')->setName('admin.settings.project.update');
})->add(AuthMiddleware::class);

$app->get('/','App\Http\Controllers\MainPageController:index')->setName('home');

$app->post('/contacts', 'App\Http\Controllers\ContactController:send');