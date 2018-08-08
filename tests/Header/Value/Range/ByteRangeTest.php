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
    public function testCanConstructRangeWithFirstByteGreaterThanLastByte(): void
    {
        $range = new ByteRange(50, 49);

        // Force generation of code coverage
        $rangeConstruct = new ByteRange(50, 49);
        self::assertEquals($range, $rangeConstruct);
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
    public function testCanConstructRangeWithFirstByteGreaterThanLastByteFromString(): void
    {
        $range = new ByteRange(50, 49);
        $rangeFromString = ByteRange::fromString('50-49');

        self::assertEquals($range, $rangeFromString);
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
    public function testRangeWithFirstByteGreaterThanLastByteIsNotSatisfiable(): void
    {
        $range = new ByteRange(50, 49);

        self::assertFalse($range->isSatisfiable(/*fileSize*/1000));
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
    public function testRangeCoveringToTheEndIsNotSatisfiableWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, null);

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

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheStartToTheEndIsSatisfiable(): void
    {
        $range = new ByteRange(0, null);

        self::assertTrue($range->isSatisfiable(/*fileSize*/1000));
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
    public function testRangeCoveringFromTheEndIsSatisfiableWhenNumberOfBytesIsGreaterThanFileSize(): void
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
    public function testRangeIsSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 100);

        self::assertTrue($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeWithSameFirstAndLastByteIsSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 50);

        self::assertTrue($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeWithFirstByteGreaterThanLastByteIsNotSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 49);

        self::assertFalse($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringToTheEndIsNotSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, null);

        self::assertFalse($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isSatisfiable
     */
    public function testRangeCoveringFromTheEndIsNotSatisfiableWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(null, 100);

        self::assertFalse($range->isSatisfiable(/*fileSize*/null));
    }

    /**
     * @covers ::isValid
     */
    public function testRangeIsValid(): void
    {
        $range = new ByteRange(50, 100);

        self::assertTrue($range->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testRangeWithSameFirstAndLastByteIsValid(): void
    {
        $range = new ByteRange(50, 50);

        self::assertTrue($range->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testRangeWithFirstByteGreaterThanLastByteIsNotValid(): void
    {
        $range = new ByteRange(50, 49);

        self::assertFalse($range->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testRangeCoveringToTheEndIsValid(): void
    {
        $range = new ByteRange(50, null);

        self::assertTrue($range->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testRangeCoveringFromTheEndIsValid(): void
    {
        $range = new ByteRange(null, 100);

        self::assertTrue($range->isValid());
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePos(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeWithSameFirstAndLastByte(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringFromTheStart(): void
    {
        $range = new ByteRange(0, 100);

        self::assertSame(0, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosWhenFirstByteIsEqualToFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/50);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/25);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosForRangeCoveringToTheEndWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/25);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosWhenLastByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/75));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringToTheEnd(): void
    {
        $range = new ByteRange(50, null);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringFromTheStartToTheEnd(): void
    {
        $range = new ByteRange(0, null);

        self::assertSame(0, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringFromTheEnd(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(900, $range->getFirstBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosForRangeCoveringZeroBytesFromTheEnd(): void
    {
        $range = new ByteRange(null, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/1000);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringFromTheEndWhenNumberOfBytesIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(0, $range->getFirstBytePos(/*fileSize*/75));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosForRangeCoveringToTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosForRangeCoveringFromTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(null, 50);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosWhenFileSizeIsNegative(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/-100);
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/null));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeWithSameFirstAndLastByteWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/null));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCanGetFirstBytePosForRangeCoveringToTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, null);

        self::assertSame(50, $range->getFirstBytePos(/*fileSize*/null));
    }

    /**
     * @covers ::getFirstBytePos
     */
    public function testCannotGetFirstBytePosForRangeCoveringFromTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(null, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getFirstBytePos(/*fileSize*/null);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePos(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(100, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeWithSameFirstAndLastByte(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(50, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeCoveringFromTheStart(): void
    {
        $range = new ByteRange(0, 100);

        self::assertSame(100, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosWhenFirstByteIsEqualToFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/50);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/25);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringToTheEndWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/25);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosWhenLastByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(74, $range->getLastBytePos(/*fileSize*/75));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeCoveringToTheEnd(): void
    {
        $range = new ByteRange(50, null);

        self::assertSame(999, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeCoveringFromTheStartToTheEnd(): void
    {
        $range = new ByteRange(0, null);

        self::assertSame(999, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeCoveringFromTheEnd(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(999, $range->getLastBytePos(/*fileSize*/1000));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringZeroBytesFromTheEnd(): void
    {
        $range = new ByteRange(null, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/1000);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeCoveringFromTheEndWhenNumberOfBytesIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(74, $range->getLastBytePos(/*fileSize*/75));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringToTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringFromTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(null, 50);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/0);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosWhenFileSizeIsNegative(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/-100);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(100, $range->getLastBytePos(/*fileSize*/null));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCanGetLastBytePosForRangeWithSameFirstAndLastByteWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(50, $range->getLastBytePos(/*fileSize*/null));
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringToTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/null);
    }

    /**
     * @covers ::getLastBytePos
     */
    public function testCannotGetLastBytePosForRangeCoveringFromTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(null, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLastBytePos(/*fileSize*/null);
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLength(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(51, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeWithSameFirstAndLastByte(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(1, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeCoveringFromTheStart(): void
    {
        $range = new ByteRange(0, 100);

        self::assertSame(101, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthWhenFirstByteIsEqualToFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/50);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/25);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringToTheEndWhenFirstByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/25);
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthWhenLastByteIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(25, $range->getLength(/*fileSize*/75));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeCoveringToTheEnd(): void
    {
        $range = new ByteRange(50, null);

        self::assertSame(950, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeCoveringFromTheStartToTheEnd(): void
    {
        $range = new ByteRange(0, null);

        self::assertSame(1000, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeCoveringFromTheEnd(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(100, $range->getLength(/*fileSize*/1000));
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringZeroBytesFromTheEnd(): void
    {
        $range = new ByteRange(null, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/1000);
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeCoveringFromTheEndWhenNumberOfBytesIsGreaterThanFileSize(): void
    {
        $range = new ByteRange(null, 100);

        self::assertSame(75, $range->getLength(/*fileSize*/75));
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, 0);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/0);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringToTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(0, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/0);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringFromTheEndWhenFileSizeIsZero(): void
    {
        $range = new ByteRange(null, 50);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/0);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthWhenFileSizeIsNegative(): void
    {
        $range = new ByteRange(50, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/-100);
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 100);

        self::assertSame(51, $range->getLength(/*fileSize*/null));
    }

    /**
     * @covers ::getLength
     */
    public function testCanGetLengthForRangeWithSameFirstAndLastByteWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, 50);

        self::assertSame(1, $range->getLength(/*fileSize*/null));
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringToTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(50, null);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/null);
    }

    /**
     * @covers ::getLength
     */
    public function testCannotGetLengthForRangeCoveringFromTheEndWhenFileSizeIsUnknown(): void
    {
        $range = new ByteRange(null, 100);

        $this->expectException(InvalidArgumentException::class);

        $range->getLength(/*fileSize*/null);
    }
}
