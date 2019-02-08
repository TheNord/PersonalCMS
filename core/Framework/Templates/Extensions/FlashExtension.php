<?php

namespace Framework\Templates\Extensions;

use Aura\Session\Segment as Session;
use Twig_Extension;
use Twig_Function;
use Twig_SimpleFunction;

class FlashExtension extends Twig_Extension
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
        return 'slim-flash';
    }

    /**
     * Callback for twig.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('flash', [$this, 'getMessages'])
        ];
    }

    /**
     * Returns Flash messages for that key.
     *
     * @param string $key
     *
     * @return array
     */
    public function getMessages($key)
    {
        return $this->session->getFlash($key);
    }
}