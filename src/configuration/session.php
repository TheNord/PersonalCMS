<?php

use Psr\Container\ContainerInterface;

return [
    \Aura\Session\SessionFactory::class => function () {
        $session_factory = new \Aura\Session\SessionFactory;
        $session = $session_factory->newInstance($_SESSION);
        return $session;
    },

	'session' => function (ContainerInterface $container) {
	    $session = $container->get(\Aura\Session\SessionFactory::class);
	    $segment = $session->getSegment('slim');
	    return $segment;
	},
];