<?php

return [
    'settings' => [
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : 'logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];