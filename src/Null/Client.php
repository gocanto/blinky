<?php

declare(strict_types=1);

namespace Blinky\Null;

use Blinky\Status;
use Blinky\Verifier;

class Client implements Verifier
{
    public function verify(string $request): Status
    {
        return Status::valid([
            'email' => 'gustavoocanto@gmail.com',
        ]);
    }
}
