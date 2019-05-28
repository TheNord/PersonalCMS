<?php


use Framework\Templates\Extensions\AuthExtension;
use Framework\Templates\Extensions\CsrfExtension;
use Psr\Container\ContainerInterface;
use Stormiix\Twig\Extension\MixExtension;
use Framework\Templates\Extensions\FlashExtension;

return [
    // view renderer
    'renderer' => function (ContainerInterface $container) {
        $settings = $container->get('settings')['renderer'];
        return new Slim\Views\PhpRenderer($settings['template_path']);
    },

    // twig renderer
    'view' => function (ContainerInterface $container) {
        $settings = $container->get('settings')['twig'];

        $view = new \Slim\Views\Twig($settings['template_path'], [
            'cache' => getenv('APP_DEBUG') ? false : $settings['cache_path'],
            'extension' => 'html.twig'
        ]);

        // Instantiate and add Slim specific extension
        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

        // Added mix extension
        $view->addExtension($container->get(MixExtension::class));

        // Added flash extension
        $view->addExtension($container->get(FlashExtension::class));

        // Added authentication helper extension
        $view->addExtension($container->get(AuthExtension::class));

        // CSRF Protection
        $view->addExtension(new CsrfExtension(
            [$container['csrf']->getTokenService(), 'generate']
        ));

        return $view;
    },

    // added manifest css and js versions
    MixExtension::class => function (ContainerInterface $container) {
        $config = $container->get('settings')['mix'];

        return new MixExtension(
            $config['root'],
            $config['manifest']
        );
    },

    // configure flash extension
    FlashExtension::class => function ($container) {
        $session = $container->get('session');
        return new FlashExtension($session);
    },

    // configure flash extension
    AuthExtension::class => function ($container) {
        $session = $container->get('session');
        return new AuthExtension($session);
    },
];