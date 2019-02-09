<?php

declare(strict_types=1);

namespace App\Entity\User\Event;

use App\Entity\User\ConfirmToken;

class UserCreated
{
    public $email;
    public $confirmToken;

    public function __construct(string $email, ConfirmToken $confirmToken)
    {
        $this->email = $email;
        $this->confirmToken = $confirmToken;
    }
}
