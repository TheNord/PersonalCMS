<?php

namespace Framework;

use http\Exception\RuntimeException;
use Psr\Container\ContainerInterface;

class Container
{
    protected static $dependencies;
    protected static $instance;

    /**
     * Create container instance
     *
     * @param array $dependencies
     * @return ContainerInterface
     */
    public static function makeInstance($dependencies): ContainerInterface
    {
        static::$dependencies = $dependencies;

        if (!isset(static::$instance)) {
            $container = new \Slim\Container(static::$dependencies);

            unset($container['errorHandler']);
            unset($container['phpErrorHandler']);
            unset($container['notFoundHandler']);

            static::$instance = $container;
        }

        return static::$instance;
    }

    /**
     * Return container instance
     *
     * @return ContainerInterface
     */
    public static function getInstance(): ContainerInterface
    {
        if (!isset(static::$instance)) {
            throw new RuntimeException('Your need initialize instance via method makeInstance');
        }
        return static::$instance;
    }
}