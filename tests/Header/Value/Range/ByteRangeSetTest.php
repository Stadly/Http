<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\Range\ByteRangeSet
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ByteRangeSetTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCannotConstructRangeSetWithoutRanges(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ByteRangeSet();
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeSetWithSingleRange(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));

        // Force generation of code coverage
        $rangeSetConstruct = new ByteRangeSet(new ByteRange(50, 100));
        self::assertEquals($rangeSet, $rangeSetConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructRangeSetWithMultipleRanges(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );

        // Force generation of code coverage
        $rangeSetConstruct = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );
        self::assertEquals($rangeSet, $rangeSetConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testDuplicateRangesAreNotRemovedWhenConstructingRangeSet(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100),
            new ByteRange(50, 50)
        );

        $rangeSetConstruct = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );
        self::assertNotEquals($rangeSet, $rangeSetConstruct);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithoutUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString('50-100');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithEmptyUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString('=50-100');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithInvalidUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString('foo=50-100');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetFromStringWithWhitespaceAroundUnit(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString("\t bytes\t  =50-100");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithoutRangesFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString('bytes=');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithoutRangesFromStringWithWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString("bytes=,\t,  ,,,");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetWithSingleRangeFromString(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));
        $rangeSetFromString = ByteRangeSet::fromString('bytes=50-100');

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetWithSingleRangeFromStringWithWhitespace(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));
        $rangeSetFromString = ByteRangeSet::fromString("bytes=,\t,  ,50-100,,");

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetWithMultipleRangesFromString(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );
        $rangeSetFromString = ByteRangeSet::fromString('bytes=50-100,50-50,50-,-100');

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeSetWithMultipleRangesFromStringWithWhitespace(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );
        $rangeSetFromString = ByteRangeSet::fromString("bytes=50-100,\t  50-50,,,50-   , \t, -100,,");

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testDuplicateRangesAreNotRemovedWhenConstructingRangeSetFromString(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100),
            new ByteRange(50, 50)
        );
        $rangeSetFromString = ByteRangeSet::fromString("bytes=50-100,50-50,50-50,50-,-100,50-50");

        self::assertEquals($rangeSet, $rangeSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructRangeSetWithInvalidRangeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ByteRangeSet::fromString('bytes=a-100');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeSetWithSingleRangeToString(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));

        self::assertSame('bytes=50-100', (string)$rangeSet);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertRangeSetWithMultipleRangesToString(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );

        self::assertSame('bytes=50-100, 50-50, 50-, -100', (string)$rangeSet);
    }

    /**
     * @covers ::getUnit
     */
    public function testCanGetUnit(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));

        self::assertSame('bytes', $rangeSet->getUnit());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForRangeSetWithSingleRange(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));

        self::assertSame('50-100', $rangeSet->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForRangeSetWithMultipleRanges(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );

        self::assertSame('50-100, 50-50, 50-, -100', $rangeSet->getValue());
    }

    /**
     * @covers ::add
     */
    public function testCanAddNothing(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100));

        $rangeSetAdd = new ByteRangeSet(new ByteRange(50, 100));
        $rangeSetAdd->add();

        self::assertEquals($rangeSet, $rangeSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddSingleRange(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 100), new ByteRange(50, 50));

        $rangeSetAdd = new ByteRangeSet(new ByteRange(50, 100));
        $rangeSetAdd->add(new ByteRange(50, 50));

        self::assertEquals($rangeSet, $rangeSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddMultipleRanges(): void
    {
        $rangeSet = new ByteRangeSet(
            new ByteRange(50, 100),
            new ByteRange(50, 50),
            new ByteRange(50, null),
            new ByteRange(null, 100)
        );

        $rangeSetAdd = new ByteRangeSet(new ByteRange(50, 100));
        $rangeSetAdd->add(new ByteRange(50, 50), new ByteRange(50, null), new ByteRange(null, 100));

        self::assertEquals($rangeSet, $rangeSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testAddingExistingRangeDoesNotOverwrite(): void
    {
        $rangeSet = new ByteRangeSet(new ByteRange(50, 50), new ByteRange(50, 100), new ByteRange(50, 50));

        $rangeSetAdd = new ByteRangeSet(new ByteRange(50, 50), new ByteRange(50, 100));
        $rangeSetAdd->add(new ByteRange(50, 50));

        self::assertEquals($rangeSet, $rangeSetAdd);
    }
}
