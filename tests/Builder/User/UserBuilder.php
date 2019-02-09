<?php

declare(strict_types=1);

namespace Tests\Builder\User;

use App\Entity\User\ConfirmToken;
use App\Entity\User\User;

class UserBuilder
{
    private $id;
    private $date;
    private $email;
    private $password;
    private $confirmToken;

    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
        $this->email = 'mail@example.com';
        $this->password = 'hash';
        $this->confirmToken = new ConfirmToken('token', new \DateTimeImmutable('+1 day'));
    }

    public function withId(int $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    public function withDate(\DateTimeImmutable $date): self
    {
        $clone = clone $this;
        $clone->date = $date;
        return $clone;
    }

    public function withEmail(string $email): self
    {
        $clone = clone $this;
        $clone->email = $email;
        return $clone;
    }

    public function withConfirmToken(ConfirmToken $confirmToken): self
    {
        $clone = clone $this;
        $clone->confirmToken = $confirmToken;
        return $clone;
    }

    public function build(): User
    {
        return new User(
            $this->date,
            $this->email,
            $this->password,
            $this->confirmToken
        );
    }
}
