<?php

use Schnittstabil\Psr7\Csrf\MiddlewareBuilder as CsrfMiddlewareBuilder;

$container['csrf'] = function ($c) {
    $key = 'fdtt435ccxgt346h';

    return CsrfMiddlewareBuilder::create($key)
        ->buildSynchronizerTokenPatternMiddleware();
};