<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

use Blinky\BlinkyException;
use Blinky\Status;
use Blinky\Verifier;
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

    /**
     * @throws BlinkyException|Throwable
     */
    public function verify(string $email): Status
    {
        try {
            $response = $this->http->retry(Config::MAX_RETRY)->request('get', Config::URL, [
                'auth' => [
                    $this->credentials->getUsername(),
                    $this->credentials->getApiKey(),
                ],
                'query' => [
                    'address' => $email,
                ],
            ]);
        } catch (Throwable $exception) {
            throw BlinkyException::fromThrowable($exception);
        }

        $payload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (mb_strtolower($payload['result']) === Config::VALID_STATUS && count($payload['reason']) === 0) {
            return Status::valid($payload);
        }

        $status = Status::invalid($payload);
        $status->setSuggestion($payload['did_you_mean'] ?? null);

        return $status;
    }
}
