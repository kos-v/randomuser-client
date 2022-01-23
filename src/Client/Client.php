<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Client;

use Kosv\RandomUser\Exceptions\TransportRequestException;
use Kosv\RandomUser\Exceptions\UnexpectedResponseException;
use Kosv\RandomUser\Interfaces\QueryBuilderInterface;
use Kosv\RandomUser\Interfaces\TransportInterface;
use Kosv\RandomUser\Transport\CurlTransport;

final class Client
{
    private const API_HOST = 'randomuser.me';
    private const API_PATH = 'api/1.3';
    private const API_SCHEME = 'https';

    private TransportInterface $transport;

    public function __construct(?TransportInterface $transport = null)
    {
        $this->transport = $transport ?? new CurlTransport();
    }

    /**
     * @throws UnexpectedResponseException
     * @throws TransportRequestException
     */
    public function request(QueryBuilderInterface $qb): Response
    {
        $response = $this->transport->get($this->buildUrl($qb));
        if ($response->getStatusCode() !== 200) {
            throw new UnexpectedResponseException('The http-server returned an unexpected http-code.');
        }

        try {
            $json = $this->decodeResponse($response->getBody());
        } catch (\JsonException $e) {
            throw new UnexpectedResponseException('The response came in an unsupported format, must be JSON.');
        }

        if (isset($json['error'])) {
            throw new UnexpectedResponseException(sprintf('Service returned error. Error text: "%s".', $json['error']));
        }

        if (!isset($json['info'], $json['results'])) {
            throw new UnexpectedResponseException('The response does not contain required data.');
        }

        return new Response($json['info'], $json['results']);
    }

    private function buildUrl(QueryBuilderInterface $qb): string
    {
        return $qb
            ->build()
            ->setScheme(self::API_SCHEME)
            ->setHost(self::API_HOST)
            ->setPath(self::API_PATH)
            ->setParam('format', ['json'])
            ->build();
    }

    private function decodeResponse(string $response): array
    {
        return json_decode($response, true, 512, \JSON_THROW_ON_ERROR);
    }
}
