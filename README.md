# Randomuser.me Client

[![Build Status](https://app.travis-ci.com/kos-v/randomuser-client.svg?branch=main)](https://app.travis-ci.com/kos-v/randomuser-client)

Simple library for getting data from [`randomuser.me`](https://randomuser.me/) service.

## Installation

```shell
composer require kosv/randomuser-client:0.0.1
```

## Example

```php
<?php

use Kosv\RandomUser\Client\{Client, QueryBuilder, Response};
use Kosv\RandomUser\Transport\CurlTransport;

$client = new Client(new CurlTransport());

$query = new QueryBuilder();
$query->setIncludeFields(['name', 'email'])->setPage(3)->setMaxResult(100);

$response = $client->request($query);
$users = $response->getUsers();
$info = $response->getInfo();

```