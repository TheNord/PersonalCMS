<?php

return [
	'session' => function () {
	    $session_factory = new \Aura\Session\SessionFactory;
	    $session = $session_factory->newInstance($_SESSION);
	    $segment = $session->getSegment('slim');

	    return $segment;
	},
];