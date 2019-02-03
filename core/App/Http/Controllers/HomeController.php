<?php

namespace App\Http\Controllers;

class HomeController
{
    protected $view;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
    }

    public function home($request, $response) {
        return $this->view->render($response, 'app/hello.html.twig');
    }

    public function about($request, $response) {
        return $this->view->render($response, 'app/about.html.twig');
    }
}