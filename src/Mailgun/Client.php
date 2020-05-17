<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

use Blinky\BlinkyException;
use Blinky\Broker;
use Blinky\Mailgun\Http\VerificationRequest;
use Blinky\Mailgun\Http\VerificationResponse;
use Blinky\Support\Json;
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

    /**
     * @throws BlinkyException
     */
    public function verify(VerificationRequest $request): VerificationResponse
    {
        try {
            $response = $this->http->retry($request->getRetries())->request('get', $request->getUrl(), [
                'auth' => [
                    $this->credentials->getUsername(),
                    $this->credentials->getApiKey(),
                ],
                'query' => [
                    'address' => $request->getAddress(),
                ],
            ]);
        } catch (Throwable $exception) {
            throw BlinkyException::fromThrowable($exception);
        }

        return new VerificationResponse(Json::decode($response->getBody()->getContents()));
    }
}
