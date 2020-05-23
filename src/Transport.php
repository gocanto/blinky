<?php

declare(strict_types=1);

namespace Blinky;

class Transport
{
    private Verifier $next;

    public function __construct(Verifier $verifier)
    {
        $this->next = $verifier;
    }

    public function verify(string $email): Status
    {
        return $this->next->verify($email);
    }
}
