<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\CacheControl\ValuelessDirective
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ValuelessDirectiveTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructDirective(): void
    {
        $directive = new ValuelessDirective('foo');

        // Force generation of code coverage
        $directiveConstruct = new ValuelessDirective('foo');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValuelessDirective('');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValuelessDirective('f o o');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForFieldList(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValuelessDirective('no-cache');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValuelessDirective('max-age');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveFromString(): void
    {
        $directive = new ValuelessDirective('foo');
        $directiveFromString = ValuelessDirective::fromString('foo');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValuelessDirective::fromString('');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValuelessDirective::fromString('f o o');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValuelessDirective::fromString('foo=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValuelessDirective::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyQuotedValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValuelessDirective::fromString('foo=""');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveToString(): void
    {
        $directive = new ValuelessDirective('foo');

        self::assertSame('foo', (string)$directive);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $directive = new ValuelessDirective('foo');

        self::assertSame('foo', $directive->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $directive = new ValuelessDirective('bar');

        $directiveSetName = new ValuelessDirective('foo');
        $directiveSetName->setName('bar');

        self::assertEquals($directive, $directiveSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $directive = new ValuelessDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $directive = new ValuelessDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('f o o');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForFieldList(): void
    {
        $directive = new ValuelessDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('no-cache');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForInteger(): void
    {
        $directive = new ValuelessDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('max-age');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $directive = new ValuelessDirective('foo');

        self::assertNull($directive->getValue());
    }
}
