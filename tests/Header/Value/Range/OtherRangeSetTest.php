<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\Range\OtherRangeSet
 * @covers ::<protected>
 * @covers ::<private>
 */
final class OtherRangeSetTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeSet(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');

        // Force generation of code coverage
        $rangeSetConstruct = new OtherRangeSet('foo', 'bar');
        self::assertEquals($rangeSet, $rangeSetConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeSetWithEmptyUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OtherRangeSet('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeSetWithInvalidUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OtherRangeSet('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeSetWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OtherRangeSet('foo', '');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeSetWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OtherRangeSet('foo', 'b a r');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetFromString(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');
        $rangeSetFromString = OtherRangeSet::fromString('foo=bar');

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithEmptyUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString('=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithInvalidUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString('f o o=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithWhitespaceAroundUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString("\t foo\t  =bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithoutValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString('foo=b a r');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithWhitespaceAroundValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OtherRangeSet::fromString("foo= \t bar\t  ");
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeSetToString(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');

        self::assertSame('foo=bar', (string)$rangeSet);
    }

    /**
     * @covers ::getUnit
     */
    public function testCanGetUnit(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');

        self::assertSame('foo', $rangeSet->getUnit());
    }

    /**
     * @covers ::setUnit
     */
    public function testCanSetUnit(): void
    {
        $otherRangeSet = new OtherRangeSet('xyzzy', 'bar');

        $otherRangeSetSetUnit = new OtherRangeSet('foo', 'bar');
        $otherRangeSetSetUnit->setUnit('xyzzy');

        self::assertEquals($otherRangeSet, $otherRangeSetSetUnit);
    }

    /**
     * @covers ::setUnit
     */
    public function testCannotSetEmptyUnit(): void
    {
        $otherRangeSet = new OtherRangeSet('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $otherRangeSet->setUnit('');
    }

    /**
     * @covers ::setUnit
     */
    public function testCannotSetInvalidUnit(): void
    {
        $otherRangeSet = new OtherRangeSet('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $otherRangeSet->setUnit('f o o');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');

        self::assertSame('bar', $rangeSet->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $otherRangeSet = new OtherRangeSet('foo', 'xyzzy');

        $otherRangeSetSetValue = new OtherRangeSet('foo', 'bar');
        $otherRangeSetSetValue->setValue('xyzzy');

        self::assertEquals($otherRangeSet, $otherRangeSetSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetEmptyValue(): void
    {
        $otherRangeSet = new OtherRangeSet('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $otherRangeSet->setValue('');
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $otherRangeSet = new OtherRangeSet('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $otherRangeSet->setValue('f o o');
    }
}
