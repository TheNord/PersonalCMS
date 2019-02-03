<?php

namespace App\Http\Controllers;

class CabinetController
{
    protected $view;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
    }

    public function index($request, $response) {
        return $this->view->render($response, 'app/cabinet.html.twig');
    }
}