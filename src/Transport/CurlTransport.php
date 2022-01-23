<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Transport;

use Kosv\RandomUser\Exceptions\TransportRequestException;
use Kosv\RandomUser\Interfaces\TransportResponseInterface;
use Kosv\RandomUser\Interfaces\TransportInterface;

final class CurlTransport implements TransportInterface
{
    private const DEFAULT_CONNECTION_TIMEOUT = 30;

    private int $connectionTimeout;

    public function __construct(int $connectionTimeout = self::DEFAULT_CONNECTION_TIMEOUT)
    {
        $this->connectionTimeout = $connectionTimeout;
    }

    /**
     * @throws TransportRequestException
     */
    public function get(string $url): TransportResponseInterface
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_CONNECTTIMEOUT => $this->connectionTimeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
        ]);

        $result = curl_exec($ch);

        $chErrCode = curl_errno($ch);
        $chErr = curl_error($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($chErrCode || $chErr) {
            throw new TransportRequestException(sprintf('Error while executing request in curl transport. Error: "%s".', $chErr));
        }

        return new Response($statusCode, (string)$result);
    }
}
