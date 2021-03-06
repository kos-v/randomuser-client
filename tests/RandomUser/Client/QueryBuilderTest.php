<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Tests\Client;

use Kosv\RandomUser\Client\QueryBuilder;
use PHPUnit\Framework\TestCase;

final class QueryBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $qb = (new QueryBuilder())
            ->setIncludeFields(['gender', 'name'])
            ->setNationalityFilter(['us'])
            ->setMaxResult(100)
            ->setPage(3);

        $this->assertEquals('/?inc=gender,name&nat=us&results=100&page=3', $qb->build()->build());
    }

    public function testSetExcludeFields(): void
    {
        $qb = new QueryBuilder();

        $qb->setExcludeFields(['gender', 'name', 'nat']);
        $this->assertEquals('/?exc=gender,name,nat', $qb->build()->build());
    }

    public function testSetGenderFilter(): void
    {
        $qb = new QueryBuilder();

        $qb->setGenderFilter('female');
        $this->assertEquals('/?gender=female', $qb->build()->build());
    }

    public function testSetIncludeFields(): void
    {
        $qb = new QueryBuilder();

        $qb->setIncludeFields(['gender', 'name', 'nat']);
        $this->assertEquals('/?inc=gender,name,nat', $qb->build()->build());
    }

    public function testSetNationalityFilter(): void
    {
        $qb = new QueryBuilder();

        $qb->setNationalityFilter(['us', 'dk', 'gb']);
        $this->assertEquals('/?nat=us,dk,gb', $qb->build()->build());
    }

    public function testSetMaxResult(): void
    {
        $qb = new QueryBuilder();

        $qb->setMaxResult(100);
        $this->assertEquals('/?results=100', $qb->build()->build());
    }

    public function testSetPage(): void
    {
        $qb = new QueryBuilder();

        $qb->setPage(3);
        $this->assertEquals('/?page=3', $qb->build()->build());
    }

    public function testSetPasswordFormat(): void
    {
        $qb = new QueryBuilder();

        $qb->setPasswordFormat(['upper', 'lower', '1-16']);
        $this->assertEquals('/?password=upper,lower,1-16', $qb->build()->build());
    }

    public function testSetSeed(): void
    {
        $qb = new QueryBuilder();

        $qb->setSeed('foobar');
        $this->assertEquals('/?seed=foobar', $qb->build()->build());
    }
}
