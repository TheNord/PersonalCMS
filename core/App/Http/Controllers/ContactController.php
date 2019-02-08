<?php

namespace App\Http\Controllers;

use App\Http\Service\ContactService;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Http\Validation\ContactFormValidation;

class ContactController
{
    protected $view;
    protected $service;
    protected $session;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
        $this->session = $container->get('session');
        $this->service = new ContactService($container);
    }

    public function index($request, $response) {
        return $this->view->render($response, 'app/contact.html.twig');
    }

    public function send(Request $request, Response $response) {
        $data = $request->getParsedBody();

        // validate form
        $validation = ContactFormValidation::validate($data);   

        if (count($validation) > 0) {
            $this->session->setFlash('errors', $validation);
            return $response->withStatus(302)->withHeader('Location', '/contact');
        }

        // store data in database and send email
        $this->service->sending($data);

        // return after all actions
        return $response->withStatus(302)->withHeader('Location', '/contact');
    }
}