<?php

use App\Http\Service\Auth\LoginService;
use App\Http\Service\Auth\RegisterService;
use App\ReadModel\Auth\UserRepository;
use Doctrine\ORM\EntityManager;
use Framework\Helpers\EventDispatcher;
use Psr\Container\ContainerInterface;

return [
    RegisterService::class => function (ContainerInterface $container) {
        return new RegisterService(
            $container->get(UserRepository::class),
            $container->get(EventDispatcher::class)
        );
    },

    LoginService::class => function (ContainerInterface $container) {
        return new LoginService(
            $container->get(UserRepository::class)
        );
    },

    UserRepository::class => function (ContainerInterface $container) {
        return new UserRepository($container->get(EntityManager::class));
    },
];