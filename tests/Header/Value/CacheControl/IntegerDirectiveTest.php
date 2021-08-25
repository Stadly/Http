<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\CacheControl\IntegerDirective
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IntegerDirectiveTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructDirective(): void
    {
        $directive = new IntegerDirective('foo', '5');

        // Force generation of code coverage
        $directiveConstruct = new IntegerDirective('foo', '5');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('', '5');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('f o o', '5');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForFieldList(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('no-cache', '5');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForValueless(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('must-revalidate', '5');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('foo', '');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new IntegerDirective('foo', 'a');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveFromString(): void
    {
        $directive = new IntegerDirective('foo', '5');
        $directiveFromString = IntegerDirective::fromString('foo=5');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        IntegerDirective::fromString('=5');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        IntegerDirective::fromString('f o o=5');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithQuotedValueFromString(): void
    {
        $directive = new IntegerDirective('foo', '5');
        $directiveFromString = IntegerDirective::fromString('foo="5"');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        IntegerDirective::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        IntegerDirective::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyQuotedValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        IntegerDirective::fromString('foo=""');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveToString(): void
    {
        $directive = new IntegerDirective('foo', '5');

        self::assertSame('foo=5', (string)$directive);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $directive = new IntegerDirective('foo', '5');

        self::assertSame('foo', $directive->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $directive = new IntegerDirective('bar', '5');

        $directiveSetName = new IntegerDirective('foo', '5');
        $directiveSetName->setName('bar');

        self::assertEquals($directive, $directiveSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('f o o');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForFieldList(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('no-cache');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForValueless(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('must-revalidate');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $directive = new IntegerDirective('foo', '5');

        self::assertSame('5', $directive->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $directive = new IntegerDirective('foo', '10');

        $directiveSetValue = new IntegerDirective('foo', '5');
        $directiveSetValue->setValue('10');

        self::assertEquals($directive, $directiveSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetEmptyValue(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setValue('');
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $directive = new IntegerDirective('foo', '5');

        $this->expectException(InvalidArgumentException::class);

        $directive->setValue('a');
    }
}
