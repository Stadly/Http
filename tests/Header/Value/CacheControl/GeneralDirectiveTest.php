<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\CacheControl\GeneralDirective
 * @covers ::<protected>
 * @covers ::<private>
 */
final class GeneralDirectiveTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructDirective(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        // Force generation of code coverage
        $directiveConstruct = new GeneralDirective('foo', 'bar');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForFieldList(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('no-cache', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('max-age', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForValueless(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('must-revalidate', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDirectiveWithoutValue(): void
    {
        $directive = new GeneralDirective('foo', null);

        // Force generation of code coverage
        $directiveConstruct = new GeneralDirective('foo', null);
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDirectiveWithEmptyValue(): void
    {
        $directive = new GeneralDirective('foo', '');

        // Force generation of code coverage
        $directiveConstruct = new GeneralDirective('foo', '');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new GeneralDirective('foo', '€-rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveFromString(): void
    {
        $directive = new GeneralDirective('foo', 'bar');
        $directiveFromString = GeneralDirective::fromString('foo=bar');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        GeneralDirective::fromString('=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        GeneralDirective::fromString('f o o=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithQuotedValueFromString(): void
    {
        $directive = new GeneralDirective('foo', 'b a r');
        $directiveFromString = GeneralDirective::fromString('foo="b a r"');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithoutValueFromString(): void
    {
        $directive = new GeneralDirective('foo');
        $directiveFromString = GeneralDirective::fromString('foo');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        GeneralDirective::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithEmptyQuotedValueFromString(): void
    {
        $directive = new GeneralDirective('foo', '');
        $directiveFromString = GeneralDirective::fromString('foo=""');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveToString(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        self::assertSame('foo=bar', (string)$directive);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveWithoutValueToString(): void
    {
        $directive = new GeneralDirective('foo');

        self::assertSame('foo', (string)$directive);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveWithEmptyValueToString(): void
    {
        $directive = new GeneralDirective('foo', '');

        self::assertSame('foo=""', (string)$directive);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveWithQuotedValueToString(): void
    {
        $directive = new GeneralDirective('foo', 'b a r');

        self::assertSame('foo="b a r"', (string)$directive);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        self::assertSame('foo', $directive->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $directive = new GeneralDirective('baz', 'bar');

        $directiveSetName = new GeneralDirective('foo', 'bar');
        $directiveSetName->setName('baz');

        self::assertEquals($directive, $directiveSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('f o o');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForFieldList(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('no-cache');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForInteger(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('max-age');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForValueless(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('must-revalidate');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        self::assertSame('bar', $directive->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $directive = new GeneralDirective('foo', 'baz');

        $directiveSetValue = new GeneralDirective('foo', 'bar');
        $directiveSetValue->setValue('baz');

        self::assertEquals($directive, $directiveSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetNullValue(): void
    {
        $directive = new GeneralDirective('foo');

        $directiveSetValue = new GeneralDirective('foo', 'bar');
        $directiveSetValue->setValue(null);

        self::assertEquals($directive, $directiveSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $directive = new GeneralDirective('foo', '');

        $directiveSetValue = new GeneralDirective('foo', 'bar');
        $directiveSetValue->setValue('');

        self::assertEquals($directive, $directiveSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetQuotedValue(): void
    {
        $directive = new GeneralDirective('foo', 'b a r');

        $directiveSetValue = new GeneralDirective('foo', 'bar');
        $directiveSetValue->setValue('b a r');

        self::assertEquals($directive, $directiveSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $directive = new GeneralDirective('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $directive->setValue('€-rate');
    }
}
