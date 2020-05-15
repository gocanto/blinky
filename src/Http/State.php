<?php

declare(strict_types=1);

namespace Blinky\Http;

use Blinky\Arrayable;

class State implements Arrayable
{
    public function __construct(array $payload)
    {
    }

    public function toArray(): array
    {
        return [];
    }
}
