<?php

use Schnittstabil\Psr7\Csrf\MiddlewareBuilder as CsrfMiddlewareBuilder;

$container['csrf'] = function ($c) {
    $key = getenv('APP_KEY');

    return CsrfMiddlewareBuilder::create($key)
        ->buildSynchronizerTokenPatternMiddleware();
};