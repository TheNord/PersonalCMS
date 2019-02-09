<?php

namespace Framework\Templates\Extensions;

use Aura\Session\Segment as Session;
use Twig_Extension;
use Twig_Function;
use Twig_SimpleFunction;

class AuthExtension extends Twig_Extension
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param Session $session the Session service provider
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'auth-helper';
    }

    /**
     * Callback for twig.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('isAuth', [$this, 'isAuth']),
            new Twig_Function('user', [$this, 'getUser']),
        ];
    }

    /**
     * Check current user authorization
     *
     * @return boolean
     */
    public function isAuth()
    {
        return !!$this->session->get('user');
    }

    /**
     * Get current authorization user
     *
     * @return boolean
     */
    public function getUser()
    {
        return $this->session->get('user');
    }
}