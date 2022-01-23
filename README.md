# Randomuser.me Client

Simple library for getting data from [`randomuser.me`](https://randomuser.me/) service.

## Example

```php
<?php

use Kosv\RandomUser\Client\{Client, QueryBuilder, Response};

$client = new Client();
$query = (new QueryBuilder())
    ->setIncludeFields(['name', 'gender'])
    ->setPage(3)
    ->setMaxResult(100);

/** @var Response $response */
$response = $client->request($query);

$users = $response->getUsers();
$info = $response->getInfo();

```