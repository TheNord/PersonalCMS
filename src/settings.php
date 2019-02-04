<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'debug' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Twig settings
        'twig' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path' => __DIR__ . '/../storage/cache',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Doctrine settings
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            'cache_dir' => __DIR__ . '/../storage/doctrine',

            'metadata_dirs' => [__DIR__ . '/../core/App/Entity'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'port' => 3306,
                'dbname' => 'app',
                'user' => 'root',
                'password' => '',
                'charset' => 'utf8'
            ]
        ],

        // CSS and JS manifest Mix settings
        'mix' => [
            'root' => '../public/build',
            'manifest' => 'mix-manifest.json',
        ],
    ],
];
