<?php

declare(strict_types=1);

namespace Blinky;

interface Verifier
{
    public function isTest(): bool;
}
