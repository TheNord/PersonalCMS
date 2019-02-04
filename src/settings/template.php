<?php

return [
    'settings' => [
        // Renderer settings
        'renderer' => [
            'template_path' => 'templates',
        ],

        // Twig settings
        'twig' => [
            'template_path' => 'templates',
            'cache_path' => 'storage/cache',
        ],

        // CSS and JS manifest Mix settings
        'mix' => [
            'root' => 'public/build',
            'manifest' => 'mix-manifest.json',
        ],
    ],
];