<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\Range\RangeSetFactory
 * @covers ::<protected>
 * @covers ::<private>
 */
final class RangeSetFactoryTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetFromString(): void
    {
        $rangeSet = new OtherRangeSet('foo', 'bar');
        $rangeSetFromString = RangeSetFactory::fromString('foo=bar');

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithWhitespaceAroundUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RangeSetFactory::fromString("\t foo\t  =bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithWhitespaceAroundValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RangeSetFactory::fromString("foo= \t bar\t  ");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RangeSetFactory::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithEmptyUnitFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RangeSetFactory::fromString('=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RangeSetFactory::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructByteRangeSetFromString(): void
    {
        $byteRangeSet = new ByteRangeSet(new ByteRange(50, 100));
        $byteRangeSetFromString = RangeSetFactory::fromString('bytes=50-100');

        self::assertEquals($byteRangeSet, $byteRangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructByteRangeSetRangeSetFromStringWithUppercaseUnit(): void
    {
        $byteRangeSet = new ByteRangeSet(new ByteRange(50, 100));
        $byteRangeSetFromString = RangeSetFactory::fromString('BYTES=50-100');

        self::assertEquals($byteRangeSet, $byteRangeSetFromString);
    }
}
