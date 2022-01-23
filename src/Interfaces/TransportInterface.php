<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Interfaces;

use Kosv\RandomUser\Exceptions\TransportRequestException;

interface TransportInterface
{
    /**
     * @throws TransportRequestException
     */
    public function get(string $url): TransportResponseInterface;
}
