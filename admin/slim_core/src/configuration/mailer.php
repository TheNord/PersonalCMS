<?php

use Psr\Container\ContainerInterface;

return [
	// mailer configuration
	'mailer' => function (ContainerInterface $container) {
	    $settings = $container->get('settings')['mailer'];

	    $transport = (new Swift_SmtpTransport($settings['host'], $settings['port']))
	        ->setUsername($settings['login'])
	        ->setPassword($settings['password'])
	    ;

	    $mailer = new Swift_Mailer($transport);

	    return $mailer;
	},
];