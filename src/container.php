<?php

use Framework\Container;

$settings = require 'settings.php';
$dependencies = require 'dependencies.php';

$configuration = array_merge($dependencies, $settings);

$container = Container::makeInstance($configuration);

return $container;