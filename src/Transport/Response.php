<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Transport;

use Kosv\RandomUser\Interfaces\TransportResponseInterface;

final class Response implements TransportResponseInterface
{
    private string $response;
    private int $statusCode;

    public function __construct(int $statusCode, string $response)
    {
        $this->statusCode = $statusCode;
        $this->response = $response;
    }

    public function getBody(): string
    {
        return $this->response;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
