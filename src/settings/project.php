<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debug' => getenv('APP_DEBUG'), // set to false in production

        'email' => getenv('MAIL_ADMIN'),
    ],
];