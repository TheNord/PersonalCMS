<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Entity\User\ConfirmToken;
use App\Entity\User\User;
use PHPUnit\Framework\TestCase;

class SignUpTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $date = new \DateTimeImmutable(),
            $email = 'mail@example.com',
            $password = 'secret',
            $token = new ConfirmToken('token', new \DateTimeImmutable('+1 day'))
        );

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());

        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($password, $user->getPassword());
        self::assertEquals($token, $user->getConfirmToken());
    }
}
