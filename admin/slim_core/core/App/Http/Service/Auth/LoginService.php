<?php

namespace App\Http\Service\Auth;

use App\Entity\User\User;
use App\ReadModel\Auth\UserRepository;
use Framework\Helpers\PasswordHasher;
use Framework\Helpers\SessionHelper;

class LoginService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Authorization user
     *
     * @param array $data
     * @throws \Exception
     * @return bool
     */
    public function login(array $data)
    {
        $user = $this->users->getByEmail($data['email']);
        $password = $user->getPassword();

        $result = PasswordHasher::validate($data['password'], $password);

        if (!$result) {
            throw new \DomainException('Wrong combination of login and password');
        }

        if (!$user->isActive()) {
            throw new \DomainException('Your need activate your account');
        }

        SessionHelper::setUser($user);

        return true;
    }

    public function logout()
    {
        SessionHelper::unsetUser();
    }
}