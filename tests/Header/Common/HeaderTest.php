<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Common\Header
 * @covers ::<protected>
 * @covers ::<private>
 */
final class HeaderTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructHeader(): void
    {
        new Header('foo', 'bar');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Header('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Header('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructHeaderWithEmptyValue(): void
    {
        new Header('foo', '');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructHeaderWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Header('foo', '€ rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Header::fromString(': bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Header::fromString('f o o: bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromString(): void
    {
        $header = new Header('foo', '');
        $headerFromString = Header::fromString('foo:');
        
        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithInvalidValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Header::fromString('foo: € rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromString(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = Header::fromString('foo:bar');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderFromStringWithWhitespaceAroundName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Header::fromString("\t  foo  \t:bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromStringWithWhitespaceAroundValue(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = Header::fromString("foo:\t  bar \t ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertHeaderToString(): void
    {
        $header = new Header('foo', 'bar');

        self::assertSame('foo: bar', (string)$header);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $header = new Header('foo', 'bar');
        
        self::assertSame('foo', $header->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $header = new Header('baz', 'bar');
        
        $headerSetName = new Header('foo', 'bar');
        $headerSetName->setName('baz');

        self::assertEquals($header, $headerSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $header = new Header('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $header->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $header = new Header('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $header->setName('f o o');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $header = new Header('foo', 'bar');
        
        self::assertSame('bar', $header->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $header = new Header('foo', 'baz');

        $headerSetValue = new Header('foo', 'bar');
        $headerSetValue->setValue('baz');

        self::assertEquals($header, $headerSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $header = new Header('foo', '');

        $headerSetValue = new Header('foo', 'bar');
        $headerSetValue->setValue('');

        self::assertEquals($header, $headerSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $header = new Header('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $header->setValue('€ rate');
    }
}
