<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Interfaces;

interface TransportResponseInterface
{
    public function getBody(): string;

    public function getStatusCode(): int;
}
