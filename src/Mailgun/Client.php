<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

use Blinky\BlinkyException;
use Blinky\Broker;
use Blinky\Http\State;
use Blinky\Http\VerifyRequest;
use Gocanto\HttpClient\HttpClient;
use Throwable;

class Client implements Broker
{
    private Credentials $credentials;
    private HttpClient $http;

    public function __construct(Credentials $credentials, HttpClient $http)
    {
        $this->credentials = $credentials;
        $this->http = $http;
    }

    public function verify(VerifyRequest $request): State
    {
        try {
            $response = $this->http->request($request->getUrl());
        } catch (Throwable $exception) {
            BlinkyException::fromThrowable($exception);
        }

        return new State();
    }
}
