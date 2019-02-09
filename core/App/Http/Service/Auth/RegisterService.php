<?php

namespace App\Http\Service\Auth;


use App\Entity\User\User;
use App\ReadModel\Auth\UserRepository;
use Framework\Helpers\EventDispatcher;
use Framework\Helpers\PasswordHasher;
use Framework\Helpers\RandConfirmTokenizer;

class RegisterService
{
    private $users;
    private $eventer;

    public function __construct(
        UserRepository $users,
        EventDispatcher $eventer
    )
    {
        $this->users = $users;
        $this->eventer = $eventer;
    }

    /**
     * Register user
     *
     * @param array $data
     * @throws \Exception
     */
    public function register(array $data)
    {
        if ($this->users->hasByEmail($data['email'])) {
            throw new \DomainException('User with this email already exists.');
        }

        $user = new User(
            \DateTimeImmutable::createFromMutable(new \DateTime()),
            $data['email'],
            PasswordHasher::hash($data['password']),
            RandConfirmTokenizer::generate()
        );

        $this->users->add($user);

        $this->eventer->dispatch($user);
    }

    /**
     * @param string $token
     * @throws \Exception
     */
    public function activate(string $token)
    {
        $user = $this->users->getByToken($token);
        $user->confirmSignup($token, new \DateTimeImmutable());
        $this->users->save();
    }
}