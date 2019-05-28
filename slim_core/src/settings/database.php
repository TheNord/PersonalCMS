<?php

return [
    'settings' => [
        // Doctrine settings
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            'cache_dir' => 'storage/doctrine',

            'metadata_dirs' => ['core/App/Entity'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'dbname' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
            ],
        ],
    ],
];