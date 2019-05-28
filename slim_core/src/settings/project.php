<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debug' => (bool)getenv('APP_DEBUG'), // set to false in production

        'email' => getenv('MAIL_ADMIN'),
        'email_from' => getenv('MAIL_FROM'),

        'root_folder' => __DIR__ . '/../../'
    ],
];