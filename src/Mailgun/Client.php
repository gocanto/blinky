<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

use Blinky\BlinkyException;
use Blinky\Contracts\VerificationRequest;
use Blinky\Contracts\VerificationResponse;
use Blinky\Verifier;
use Blinky\Support\Json;
use Gocanto\HttpClient\HttpClient;
use Throwable;

class Client implements Verifier
{
    private Credentials $credentials;
    private HttpClient $http;

    public function __construct(Credentials $credentials, HttpClient $http)
    {
        $this->credentials = $credentials;
        $this->http = $http;
    }

    public function isTest(): bool
    {
        return $this->credentials->isTest();
    }

    /**
     * @param VerificationRequest $request
     * @return VerificationResponse
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

        return new VerifyResponse(Json::decode($response->getBody()->getContents()));
    }
}
