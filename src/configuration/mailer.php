<?php

// mailer configuration
$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['mailer'];

    $transport = (new Swift_SmtpTransport($settings['host'], $settings['port']))
        ->setUsername($settings['login'])
        ->setPassword($settings['password'])
    ;

    $mailer = new Swift_Mailer($transport);

    return $mailer;
};