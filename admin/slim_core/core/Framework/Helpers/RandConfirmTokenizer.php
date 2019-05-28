<?php

declare(strict_types=1);

namespace Framework\Helpers;

use App\Entity\User\ConfirmToken;

class RandConfirmTokenizer
{
    /**
     * Generate random token
     *
     * @return ConfirmToken
     * @throws \Exception
     */
    public static function generate(): ConfirmToken
    {
        return new ConfirmToken(
            (string)random_int(100000, 999999),
            $res = (new \DateTimeImmutable())->add(new \DateInterval('PT1H'))
        );
    }
}
