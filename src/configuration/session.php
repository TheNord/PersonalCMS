<?php

$container['session'] = function ($c) {
    $session_factory = new \Aura\Session\SessionFactory;
    $session = $session_factory->newInstance($_SESSION);
    $segment = $session->getSegment('slim11');

    return $segment;
};