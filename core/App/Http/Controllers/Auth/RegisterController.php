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
            return redirect($response)->with('status', $e->getMessage())->route('register.index');
        }

        return redirect($response)
            ->with('status', 'Your account is successfully registered! Please check your email, and activate your account.')
            ->route('register.index');
    }

    /**
     * Activate user account after registration
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function activate(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $token = $request->getAttribute('token');
            $this->service->activate($token);
        } catch (\Exception $e) {
            return redirect($response)->with('status', $e->getMessage())->route('register.index');
        }

        return redirect($response)
            ->with('status', 'Your account is successfully activated!')
            ->route('register.index');
    }
}