<?php

declare(strict_types=1);

namespace Framework\Contracts\Events;

interface AggregateRoot
{
    public function releaseEvents(): array;
}
