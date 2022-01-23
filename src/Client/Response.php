<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Client;

final class Response
{
    private array $info;
    private array $users;

    public function __construct(array $info, array $users)
    {
        $this->info = $info;
        $this->users = $users;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}
