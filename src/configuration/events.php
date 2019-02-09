<?php

use App\Entity\User\Event\UserCreated;
use App\Listeners\User\CreatedListener;
use Framework\Helpers\EventDispatcher;
use Psr\Container\ContainerInterface;

return [
    EventDispatcher::class => function (ContainerInterface $container) {
        return new EventDispatcher(
            $container,
            [
                UserCreated::class => [
                    CreatedListener::class,
                ],
            ]
        );
    },

    CreatedListener::class => function (ContainerInterface $container) {
        return new CreatedListener(
            $container->get('mailer'),
            $container->get('settings')['email_from']
        );
    },
];
