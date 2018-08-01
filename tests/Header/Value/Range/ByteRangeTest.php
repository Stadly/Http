<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\Range\ByteRange
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ByteRangeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructRange(): void
    {
        $range = new ByteRange(50, 100);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(50, 100);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeWithSameFirstAndLastByte(): void
    {
        $range = new ByteRange(50, 50);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(50, 50);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeWithFirstByteGreaterThanLastByte(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ByteRange(50, 49);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeCoveringFromTheStart(): void
    {
        $range = new ByteRange(0, 100);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(0, 100);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeCoveringToTheEnd(): void
    {
        $range = new ByteRange(50, null);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(50, null);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeCoveringFromTheStartToTheEnd(): void
    {
        $range = new ByteRange(0, null);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(0, null);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeCoveringFromTheEnd(): void
    {
        $range = new ByteRange(null, 100);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(null, 100);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeCoveringZeroBytesFromTheEnd(): void
    {
        $range = new ByteRange(null, 0);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(null, 0);
        self::assertEquals($range, $rangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeWithNeitherFirstByteNorLastByte(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ByteRange(null, null);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeWithNegativeFirstByte(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ByteRange(-50, null);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeWithNegativeLastByte(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ByteRange(null, -100);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeFromString(): void
    {
        $range = new ByteRange(50, 100);
        $rangeFromString = ByteRange::fromString('50-100');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeWithSameFirstAndLastByteFromString(): void
    {
        $range = new ByteRange(50, 50);
        $rangeFromString = ByteRange::fromString('50-50');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithFirstByteGreaterThanLastByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('50-49');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeCoveringFromTheStartFromString(): void
    {
        $range = new ByteRange(0, 100);
        $rangeFromString = ByteRange::fromString('0-100');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeCoveringToTheEndFromString(): void
    {
        $range = new ByteRange(50, null);
        $rangeFromString = ByteRange::fromString('50-');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeCoveringFromTheStartToTheEndFromString(): void
    {
        $range = new ByteRange(0, null);
        $rangeFromString = ByteRange::fromString('0-');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeCoveringFromTheEndFromString(): void
    {
        $range = new ByteRange(null, 100);
        $rangeFromString = ByteRange::fromString('-100');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeCoveringZeroBytesFromTheEndFromString(): void
    {
        $range = new ByteRange(null, 0);
        $rangeFromString = ByteRange::fromString('-0');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithNeitherFirstByteNorLastByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('-');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithNegativeFirstByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('-50-');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithNegativeLastByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('--100');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructInvalidRangeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('50');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithInvalidFirstByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('a-100');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithInvalidLastByteFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString('50-b');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeWithWhitespaceFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRange::fromString(' 50-100');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeToString(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame('50-100', (string)$range);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeWithSameFirstAndLastByteToString(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame('50-50', (string)$range);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeCoveringToTheEndToString(): void
    {
        $range = new ByteRange(50, null);

        self::assertSame('50-', (string)$range);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeCoveringFromTheEndToString(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame('-100', (string)$range);
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsSatisfiable(): void
    {
        $range = new ByteRange(50, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeWithSameFirstAndLastByteIsSatisfiable(): void
    {
        $range = new ByteRange(50, 50);

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheStartIsSatisfiable(): void
    {
        $range = new ByteRange(0, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsNotSatisfiableWhenFirstByteIsEqualToFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertFalse($range->isSatisfiable(/*fileSize*/50));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsNotSatisfiableWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertFalse($range->isSatisfiable(/*fileSize*/25));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsSatisfiableWhenLastByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/75));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringToTheEndIsSatisfiable(): void
    {
        $range = new ByteRange(50, null);

        self::assertTrue($range->isSatisfiable(/*fileSize*/100));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheStartToTheEndIsSatisfiable(): void
    {
        $range = new ByteRange(0, null);

        self::assertTrue($range->isSatisfiable(/*fileSize*/100));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheEndIsSatisfiable(): void
    {
        $range = new ByteRange(null, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringZeroBytesFromTheEndIsNotSatisfiable(): void
    {
        $range = new ByteRange(null, 0);

        self::assertFalse($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheEndIsSatisfiableWhenNumberOfCoveredBytesIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(null, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/75));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsNotSatisfiableWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, 0);

        self::assertFalse($range->isSatisfiable(/*fileSize*/0));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringToTheEndIsNotSatisfiableWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, null);

        self::assertFalse($range->isSatisfiable(/*fileSize*/0));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheEndIsSatisfiableWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(null, 50);

        self::assertTrue($range->isSatisfiable(/*fileSize*/0));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsNotSatisfiableWhenFileSizeIsNegative(): void
    {
        $range = new ByteRange(50, 100);

        self::assertFalse($range->isSatisfiable(/*fileSize*/-100));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringToTheEndIsSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, null);

        self::assertTrue($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheEndIsSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(null, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeIsSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/null));
    }
}
