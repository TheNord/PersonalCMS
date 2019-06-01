<?php

use App\Http\Middleware\AdminAccessMiddleware;
use App\Http\Middleware\AuthMiddleware;

// Auth routes
$app->get('/register', 'App\Http\Controllers\Auth\RegisterController:index')->setName('register.index');
$app->post('/register', 'App\Http\Controllers\Auth\RegisterController:register')->setName('register.store');

$app->get('/login', 'App\Http\Controllers\Auth\LoginController:index')->setName('login.index');
$app->post('/login', 'App\Http\Controllers\Auth\LoginController:login')->setName('login.check');

$app->post('/logout', 'App\Http\Controllers\Auth\LoginController:logout')->setName('logout');

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
    $app->delete('/contacts/{id}/destroy', 'App\Http\Controllers\Admin\ContactController:destroy')->setName('admin.contacts.destroy');

    // Site settings
    $app->get('/settings', 'App\Http\Controllers\Admin\SettingsController:index')->setName('admin.settings');

    $app->get('/settings/robots', 'App\Http\Controllers\Admin\SettingsController:robots')->setName('admin.settings.robots');
    $app->put('/settings/robots', 'App\Http\Controllers\Admin\SettingsController:robotsUpdate')->setName('admin.settings.robots.update');

    $app->get('/settings/project', 'App\Http\Controllers\Admin\SettingsController:project')->setName('admin.settings.project');
    $app->put('/settings/project', 'App\Http\Controllers\Admin\SettingsController:projectUpdate')->setName('admin.settings.project.update');

    // Counters setting
    $app->get('/settings/counters', 'App\Http\Controllers\Admin\SettingsController:counters')->setName('admin.settings.counters');
    $app->put('/settings/counters', 'App\Http\Controllers\Admin\SettingsController:countersUpdate')->setName('admin.settings.counters.update');

    // Admin profile
    $app->get('/profile', 'App\Http\Controllers\Admin\ProfileController:index')->setName('admin.profile');
    $app->put('/profile', 'App\Http\Controllers\Admin\ProfileController:update')->setName('admin.profile.update');

    // Ajax images upload
    $app->post('/upload/image', 'App\Http\Controllers\Admin\UploadsController:storeImage');
})->add(AdminAccessMiddleware::class);

$app->get('/','App\Http\Controllers\MainPageController:index')->setName('home');

$app->post('/contacts', 'App\Http\Controllers\ContactController:send');