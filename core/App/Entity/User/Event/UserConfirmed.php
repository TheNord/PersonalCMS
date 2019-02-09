<?php

declare(strict_types=1);

namespace App\Entity\User\Event;

class UserConfirmed
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
