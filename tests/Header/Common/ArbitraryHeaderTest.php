<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Common\ArbitraryHeader
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ArbitraryHeaderTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructHeader(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        // Force generation of code coverage
        $headerConstruct = new ArbitraryHeader('foo', 'bar');
        self::assertEquals($header, $headerConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ArbitraryHeader('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ArbitraryHeader('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructHeaderWithEmptyValue(): void
    {
        $header = new ArbitraryHeader('foo', '');

        // Force generation of code coverage
        $headerConstruct = new ArbitraryHeader('foo', '');
        self::assertEquals($header, $headerConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ArbitraryHeader('foo', '€-rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromString(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');
        $headerFromString = ArbitraryHeader::fromString('foo:bar');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ArbitraryHeader::fromString(': bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ArbitraryHeader::fromString('f o o: bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromString(): void
    {
        $header = new ArbitraryHeader('foo', '');
        $headerFromString = ArbitraryHeader::fromString('foo:');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithInvalidValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ArbitraryHeader::fromString('foo: €-rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderFromStringWithWhitespaceAroundName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ArbitraryHeader::fromString("\t  foo  \t:bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromStringWithWhitespaceAroundValue(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');
        $headerFromString = ArbitraryHeader::fromString("foo:\t  bar \t ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertHeaderToString(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        self::assertSame('foo: bar', (string)$header);
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        self::assertTrue($header->isValid()); // @phpstan-ignore-line
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        self::assertSame('foo', $header->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $header = new ArbitraryHeader('baz', 'bar');

        $headerSetName = new ArbitraryHeader('foo', 'bar');
        $headerSetName->setName('baz');

        self::assertEquals($header, $headerSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $header->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $header->setName('f o o');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        self::assertSame('bar', $header->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $header = new ArbitraryHeader('foo', 'baz');

        $headerSetValue = new ArbitraryHeader('foo', 'bar');
        $headerSetValue->setValue('baz');

        self::assertEquals($header, $headerSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $header = new ArbitraryHeader('foo', '');

        $headerSetValue = new ArbitraryHeader('foo', 'bar');
        $headerSetValue->setValue('');

        self::assertEquals($header, $headerSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $header->setValue('€-rate');
    }
}
