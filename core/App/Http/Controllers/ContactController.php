<?php

namespace App\Http\Controllers;

class ContactController
{
    protected $view;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
    }

    public function index($request, $response) {
        return $this->view->render($response, 'app/contact.html.twig');
    }

    public function send($request, $response) {
        // sending actions...

        return $this->view->render($response, 'app/contact.html.twig', [
            'status' => 'Successfully sent!'
        ]);
    }
}