<?php

use Schnittstabil\Psr7\Csrf\MiddlewareBuilder as CsrfMiddlewareBuilder;

return [
	'csrf' => function () {
	    $key = getenv('APP_KEY');

	    return CsrfMiddlewareBuilder::create($key)
	        ->buildSynchronizerTokenPatternMiddleware();
	},
];