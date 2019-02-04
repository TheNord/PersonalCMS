<?php

namespace App\Http\Controllers;

use App\Http\Service\ContactService;
use Slim\Http\Request;
use Slim\Http\Response;

class ContactController
{
    protected $view;
    protected $service;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
        $this->service = new ContactService($container);
    }

    public function index($request, $response) {
        return $this->view->render($response, 'app/contact.html.twig');
    }

    public function send(Request $request, Response $response) {
        $data = $request->getParsedBody();

        $this->service->sending($data);

        // need redirect user
        return $this->view->render($response, 'app/contact.html.twig', [
            'status' => 'Successfully sent!'
        ]);
    }
}