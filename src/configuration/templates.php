<?php


use Stormiix\Twig\Extension\MixExtension;

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// twig renderer
$container['view'] = function ($c) {
    $settings = $c->get('settings')['twig'];

    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => $settings['cache_path'],
        'extension' => 'html.twig'
    ]);

    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    // Added mix extension
    $view->addExtension($c->get(MixExtension::class));

    return $view;
};

// added manifest css and js versions
$container[MixExtension::class] = function ($c) {
    $config = $c->get('settings')['mix'];

    return new MixExtension(
        $config['root'],
        $config['manifest']
    );
};