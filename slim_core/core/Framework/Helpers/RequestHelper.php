<?php

namespace Framework\Helpers;

use Psr\Http\Message\RequestInterface;

class RequestHelper
{
    public static function wantsJson(RequestInterface $request)
    {
        $type = $request->getContentType();

        return strpos($type, 'application/json') === 0 ? true : false;
    }
}