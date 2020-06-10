<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit\Mailgun;

use Blinky\BlinkyException;
use Blinky\Mailgun\Client;
use Blinky\Mailgun\Config;
use Blinky\Mailgun\Credentials;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;

    /** @var Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $http;

    protected function setUp(): void
    {
        $this->http = Mockery::mock(ClientInterface::class);
        $this->client = new Client($this->getCredentials(), $this->http);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @test
     * @throws BlinkyException
     */
    public function itProperlyValidatesGivenAddresses(): void
    {
        $withRequest = static function ($method, $url, $attributes): bool {
            return $method === 'get' &&
                $url === Config::URL &&
                $attributes['auth'][0] === 'api' && $attributes['auth'][1] === 'key-foo' &&
                $attributes['query']['address'] === 'gustavoocanto@gmail.com';
        };

        $this->http->shouldReceive('request')->once()->withArgs($withRequest)->andReturn($this->getPayload());

        $response = $this->client->verify('gustavoocanto@gmail.com');

        $this->assertTrue($response->isValid());

        $data = $response->toArray();
        $this->assertSame('gustavoocanto@gmail.com', $data['address']);
        $this->assertSame('deliverable', $data['result']);
        $this->assertSame('low', $data['risk']);
        $this->assertFalse($data['is_disposable_address']);
        $this->assertFalse($data['is_role_address']);
        $this->assertCount(0, $data['reason']);
    }

    /**
     * @test
     * @throws BlinkyException
     */
    public function itReturnInvalidResponsesWhenGivenEmailsAreInvalid(): void
    {
        $this->http->shouldReceive('request')->once()->andReturn($this->getPayload(false));

        $response = $this->client->verify('gustavoocanto@gmail.com');

        $this->assertFalse($response->isValid());

        $data = $response->toArray();
        $this->assertSame('gustavoocant@gmail.com', $data['address']);
        $this->assertSame('undeliverable', $data['result']);
        $this->assertSame('high', $data['risk']);
        $this->assertFalse($data['is_disposable_address']);
        $this->assertFalse($data['is_role_address']);
        $this->assertCount(1, $data['reason']);
        $this->assertTrue($response->hasSuggestion());
        $this->assertSame('gustavoocanto@gmail.com', $response->getSuggestion());
    }

    /**
     * @test
     */
    public function itThrowsExceptionsOnInvalidHttpRequest(): void
    {
        $this->expectException(BlinkyException::class);

        $this->http->shouldReceive('request')->once()->andThrow(BlinkyException::class);

        $this->client->verify('invalid@gmail.com');
    }

    private function getCredentials(): Credentials
    {
        $credentials = Credentials::test();

        $credentials->setUsername('api');
        $credentials->setApiKey('key-foo');

        return $credentials;
    }

    private function getPayload(bool $valid = true): Response
    {
        $data = file_get_contents(__DIR__ . ($valid ? '/valid_response.json' : '/invalid_response.json'));

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody->getContents')->once()->andReturn($data)->getMock();

        return $response;
    }
}
