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
                'host' => 'localhost',
                'port' => 3306,
                'dbname' => 'app',
                'user' => 'root',
                'password' => 'new-password',
                'charset' => 'utf8'
            ]
        ],
    ],
];