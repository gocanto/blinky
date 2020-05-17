<?php

declare(strict_types=1);

namespace Blinky\Null;

use Blinky\Contracts\VerificationRequest;
use Blinky\Contracts\VerificationResponse;
use Blinky\Verifier;

class Client implements Verifier
{
    public function isTest(): bool
    {
        return true;
    }

    /**
     * @param VerificationRequest|VerifyRequest $request
     */
    public function verify(VerificationRequest $request): VerificationResponse
    {
        return new VerifyResponse($request->getAttribute());
    }
}
