<?php

return [
    'settings' => [
        // Global templates settings
        'templates' => [
            // template file extension
            'extension' => '.html.twig'
        ],

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