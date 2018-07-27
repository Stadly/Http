<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\Range\ByteRange;
use Stadly\Http\Header\Value\Range\ByteRangeSet;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\Range
 * @covers ::<protected>
 * @covers ::<private>
 */
final class RangeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructRange(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));

        // Force generation of code coverage
        $rangeConstruct = new Range(new ByteRangeSet(new ByteRange(10, 100)));
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__toString
     */
    public function testCannotConvertRangeWithoutRangesToString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $range = new Range(new ByteRangeSet());

        (string)$range;
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeWithSingleRangeToString(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));

        self::assertSame('Range: bytes=10-100', (string)$range);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeWithMultipleRangesToString(): void
    {
        $range = new Range(new ByteRangeSet(
            new ByteRange(10, 100),
            new ByteRange(50, null),
            new ByteRange(null, 100),
            new ByteRange(0, 0)
        ));

        self::assertSame('Range: bytes=10-100, 50-, -100, 0-0', (string)$range);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));

        self::assertSame('Range', $range->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCannotGetValueForRangeWithoutRanges(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $range = new Range(new ByteRangeSet());

        $range->getValue();
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForRangeWithSingleRange(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));

        self::assertSame('bytes=10-100', $range->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForRangeWithMultipleRanges(): void
    {
        $range = new Range(new ByteRangeSet(
            new ByteRange(10, 100),
            new ByteRange(50, null),
            new ByteRange(null, 100),
            new ByteRange(0, 0)
        ));

        self::assertSame('bytes=10-100, 50-, -100, 0-0', $range->getValue());
    }

    /**
     * @covers ::getRangeSet
     */
    public function testCanGetRangeSet(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(10, 100));
        $range = new Range($rangeSet);

        self::assertSame($rangeSet, $range->getRangeSet());
    }

    /**
     * @covers ::setRangeSet
     */
    public function testCanSetRangeSet(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(10, 100));
        $range = new Range($rangeSet);

        $rangeSetType = new Range(new ByteRangeSet(new ByteRange(50, null)));
        $rangeSetType->setRangeSet($rangeSet);

        self::assertEquals($range, $rangeSetType);
    }
}
