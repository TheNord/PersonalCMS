<?php

namespace App\Http\Service\Auth;


use App\Entity\User\User;
use App\ReadModel\Auth\UserRepository;
use Framework\Helpers\PasswordHasher;

class RegisterService
{
    private $users;
    private $eventer;

    public function __construct(
        UserRepository $users
    )
    {
        $this->users = $users;
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
            throw new \DomainException('Пользователь с таким email уже зарегистрирован.');
        }

        $user = new User(
            \DateTimeImmutable::createFromMutable(new \DateTime()),
            $data['name'],
            $data['email'],
            PasswordHasher::hash($data['password'])
        );

        $this->users->add($user);
    }
}