<?php

namespace App\Http\Controllers\Auth;

use App\Http\Service\Auth\LoginService;
use App\Http\Validation\Auth\LoginFormValidation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController
{
    /**
     * @var LoginService
     */
    private $service;

    public function __construct(ContainerInterface $container)
    {
        $this->service = $container->get(LoginService::class);
    }

    public function index()
    {
        return view('app/auth/login');
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $validation = LoginFormValidation::validate($data);

        if ($validation) {
            return redirect($response)->with('errors', $validation)->route('login.index');
        }

        try {
            $this->service->login($data);
        } catch (\Exception $e) {
            return redirect($response)->with('error', 'Неверная комбинация логина и пароля')->route('login.index');
        }

        return redirect($response)->route('home');
    }

    public function logout(RequestInterface $request, ResponseInterface $response)
    {
        $this->service->logout();
        return redirect($response)->route('login.index');
    }
}