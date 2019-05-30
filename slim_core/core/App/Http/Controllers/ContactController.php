<?php

namespace App\Http\Controllers;

use App\Http\Service\ContactService;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Http\Validation\ContactFormValidation;
use Psr\Container\ContainerInterface;

class ContactController
{
    protected $service;

    public function __construct(ContainerInterface $container) {
        $this->service = new ContactService($container);
    }

    public function send(RequestInterface $request, ResponseInterface $response) {
        $data = $request->getParsedBody();

        // validate form
        $validation = ContactFormValidation::validate($data);   

        // if we have validation errors, return contact page and set flash data errors (method with())
        if ($validation) {
            return redirect($response)->with('errors', $validation)->route('home');
        }

        $filter = $this->service->checkSpam();

        // spam filter, sending letters no more once in ten minutes
        if ($filter) {
            return redirect($response)->with('error', 'Ранее вы отправляли сообщение, пожалуйста подождите.')->route('home');
        }

        // store data in database and send email
        $this->service->sending($data);

        // return after all actions
        return redirect($response)->with('success', 'Ваше сообщение успешно отправлено!')->route('home');
    }
}