<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use DateTime;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Date;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\IfUnmodifiedSince
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IfUnmodifiedSinceTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructIfUnmodifiedSince(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        // Force generation of code coverage
        $ifUnmodifiedSinceConstruct = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        self::assertEquals($ifUnmodifiedSince, $ifUnmodifiedSinceConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructIfUnmodifiedSinceWithEmptyDateFromValue(): void
    {
        $this->expectException(InvalidHeader::class);

        IfUnmodifiedSince::fromValue('');
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfUnmodifiedSinceFromValue(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $ifUnmodifiedSinceFromValue = IfUnmodifiedSince::fromValue('Sat, 03 Feb 2001 04:05:06 GMT');

        self::assertEquals($ifUnmodifiedSince, $ifUnmodifiedSinceFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfUnmodifiedSinceToString(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('If-Unmodified-Since: Sat, 03 Feb 2001 04:05:06 GMT', (string)$ifUnmodifiedSince);
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertTrue($ifUnmodifiedSince->isValid()); // @phpstan-ignore-line
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('If-Unmodified-Since', $ifUnmodifiedSince->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfUnmodifiedSince(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('Sat, 03 Feb 2001 04:05:06 GMT', $ifUnmodifiedSince->getValue());
    }

    /**
     * @covers ::evaluate
     */
    public function testIfUnmodifiedSinceEvaluatesToFalseWhenLastModifiedDateIsUnknown(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = null;

        self::assertFalse($ifUnmodifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfUnmodifiedSinceEvaluatesToTrueWhenLastModifiedDateIsEarlier(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2000-01-02 03:04:05'));

        self::assertTrue($ifUnmodifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfUnmodifiedSinceEvaluatesToTrueWhenLastModifiedDateIsTheSame(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($ifUnmodifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfUnmodifiedSinceEvaluatesToFalseWhenLastModifiedDateIsLater(): void
    {
        $ifUnmodifiedSince = new IfUnmodifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertFalse($ifUnmodifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::getDate
     */
    public function testCanGetDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));
        $ifUnmodifiedSince = new IfUnmodifiedSince($date);

        self::assertSame($date, $ifUnmodifiedSince->getDate());
    }

    /**
     * @covers ::setDate
     */
    public function testCanSetDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));
        $ifUnmodifiedSince = new IfUnmodifiedSince($date);

        $ifUnmodifiedSinceSetDate = new IfUnmodifiedSince(new Date(new DateTime('2002-03-04 05:06:07')));
        $ifUnmodifiedSinceSetDate->setDate($date);

        self::assertEquals($ifUnmodifiedSince, $ifUnmodifiedSinceSetDate);
    }
}
