<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Tests\Url;

use Kosv\RandomUser\Url\AbstractBuilder;
use PHPUnit\Framework\TestCase;

final class AbstractBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $builder = $this->makeUrlBuilderStub()
            ->setScheme('https')
            ->setHost('randomuser.me')
            ->setPath('api/1.3')
            ->setParam('nat', ['us', 'dk']);

        $this->assertEquals('https://randomuser.me/api/1.3?nat=us,dk', $builder->build());
    }

    public function testSetHost(): void
    {
        $builder = $this->makeUrlBuilderStub();

        $builder->setHost('example.local');
        $this->assertEquals('example.local', $builder->build());

        $builder->setHost('');
        $this->assertEquals('', $builder->build());
    }

    public function testSetPath(): void
    {
        $builder = $this->makeUrlBuilderStub();

        $builder->setPath('api/1.3');
        $this->assertEquals('/api/1.3', $builder->build());

        $builder->setPath('');
        $this->assertEquals('', $builder->build());
    }

    public function testSetParam(): void
    {
        $builder = $this->makeUrlBuilderStub();

        $builder->setParam('foo', ['a']);
        $this->assertEquals('/?foo=a', $builder->build());

        $builder->setParam('foo', ['a']);
        $builder->setParam('bar', ['b']);
        $this->assertEquals('/?foo=a&bar=b', $builder->build());

        $builder->setParam('foo', ['a', 'b']);
        $builder->setParam('bar', ['c', 'd', 'e']);
        $this->assertEquals('/?foo=a,b&bar=c,d,e', $builder->build());
    }

    public function testSetScheme(): void
    {
        $builder = $this->makeUrlBuilderStub();

        $builder->setScheme('http');
        $this->assertEquals('http://', $builder->build());

        $builder->setScheme('');
        $this->assertEquals('', $builder->build());
    }

    private function makeUrlBuilderStub(): AbstractBuilder
    {
        return new class () extends AbstractBuilder {
        };
    }
}
