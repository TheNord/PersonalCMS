<?php

return [
    'settings' => [
        // Mailer settings
        'mailer' => [
            'host' => getenv('MAIL_HOST'),
            'port' => getenv('MAIL_PORT'),
            'login' => getenv('MAIL_LOGIN'),
            'password' => getenv('MAIL_PASSWORD')
        ],
    ],
];
