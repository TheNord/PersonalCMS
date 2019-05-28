<?php

declare(strict_types=1);

namespace Framework\Helpers;

class PasswordHasher
{
    private static $cost = 12;

    public static function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => static::$cost]);
        if ($hash === false) {
            throw new \RuntimeException('Unable to generate hash.');
        }
        return $hash;
    }

    public static function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
