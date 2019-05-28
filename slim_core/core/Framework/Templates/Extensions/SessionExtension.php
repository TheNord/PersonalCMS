<?php

namespace Framework\Templates\Extensions;

use Aura\Session\Segment as Session;
use Twig_Extension;
use Twig_Function;
use Twig_SimpleFunction;

class SessionExtension extends Twig_Extension
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
        return 'session';
    }

    /**
     * Callback for twig.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('session', [$this, 'getSession'])
        ];
    }

    /**
     * Returns Flash messages for that key.
     *
     * @param string $key
     *
     * @return array
     */
    public function getSession($key)
    {
        return $this->session->get($key);
    }
}