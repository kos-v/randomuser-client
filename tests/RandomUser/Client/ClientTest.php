<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Tests\Client;

use Kosv\RandomUser\Client\Client;
use Kosv\RandomUser\Client\QueryBuilder;
use Kosv\RandomUser\Client\Response as ClientResponse;
use Kosv\RandomUser\Exceptions\UnexpectedResponseException;
use Kosv\RandomUser\Interfaces\TransportInterface;
use Kosv\RandomUser\Transport\Response as TransportResponse;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testRequestWhenApiReturnErr(): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Service returned error. Error text: "test error".');

        $transport = $this->createMock(TransportInterface::class);
        $transport->method('get')->willReturn(new TransportResponse(200, '{"error": "test error"}'));

        $client = new Client($transport);
        $client->request(new QueryBuilder());
    }

    public function testRequestWhenNotJson(): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('The response came in an unsupported format, must be JSON.');

        $transport = $this->createMock(TransportInterface::class);
        $transport->method('get')->willReturn(new TransportResponse(200, '<p>test</p>'));

        $client = new Client($transport);
        $client->request(new QueryBuilder());
    }

    public function testRequestWhenNotValidResponse(): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('The response does not contain required data.');

        $transport = $this->createMock(TransportInterface::class);
        $transport->method('get')->willReturn(new TransportResponse(200, '{"info": {}}'));

        $client = new Client($transport);
        $client->request(new QueryBuilder());
    }

    public function testRequestWhenOk(): void
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport->method('get')->willReturn(new TransportResponse(200, '{"info": {}, "results": []}'));

        $client = new Client($transport);
        $this->assertInstanceOf(ClientResponse::class, $client->request(new QueryBuilder()));
    }

    public function testRequestWhenResponse500(): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('The http-server returned an unexpected http-code.');

        $transport = $this->createMock(TransportInterface::class);
        $transport->method('get')->willReturn(new TransportResponse(500, ''));

        $client = new Client($transport);
        $client->request(new QueryBuilder());
    }
}
