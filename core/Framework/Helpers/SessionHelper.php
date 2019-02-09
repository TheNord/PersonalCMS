<?php

namespace Framework\Helpers;


use App\Entity\User\User;
use Aura\Session\SessionFactory;
use Framework\Container;

class SessionHelper
{
    private static function getSession()
    {
        return Container::getInstance()->get(SessionFactory::class);
    }

    public static function regenerateId()
    {
        $session = self::getSession();
        $session->regenerateId();
    }

    public static function setUser(User $user)
    {
        session('user', $user);
        self::regenerateId();
    }

    public static function unsetUser()
    {
        session('user', null);
        self::regenerateId();
    }
}