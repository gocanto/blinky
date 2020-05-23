<?php

declare(strict_types=1);

namespace Blinky\Null;

use Blinky\Status;
use Blinky\Verifier;

class Client implements Verifier
{
    public function verify(string $email): Status
    {
        return Status::valid([
            'address' => $email,
        ]);
    }
}
