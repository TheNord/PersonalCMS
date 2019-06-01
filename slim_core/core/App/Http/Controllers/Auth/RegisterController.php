<?php

namespace App\Http\Controllers\Auth;

use App\Http\Service\Auth\RegisterService;
use App\Http\Validation\Auth\RegisterFormValidation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RegisterController
{
    /**
     * @var RegisterService
     */
    private $service;

    public function __construct(ContainerInterface $container)
    {
        $this->service = $container->get(RegisterService::class);
    }

    public function index()
    {
        return view('app/auth/register');
    }

    /**
     * Register user and dispatch events
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Exception
     */
    public function register(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $validation = RegisterFormValidation::validate($data);

        if ($validation) {
            return redirect($response)->with('errors', $validation)->route('register.index');
        }

        try {
            $this->service->register($data);
        } catch (\DomainException $e) {
            return redirect($response)->with('error', $e->getMessage())->route('register.index');
        }

        return redirect($response)
            ->with('success', 'Аккаунт был успешно зарегистрирован.')
            ->route('register.index');
    }
}