<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Interfaces;

use Kosv\RandomUser\Url\AbstractBuilder as AbstractUrlBuilder;

interface QueryBuilderInterface
{
    public function build(): AbstractUrlBuilder;
}
