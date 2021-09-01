<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use DateTime;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Date;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\IfModifiedSince
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IfModifiedSinceTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructIfModifiedSince(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        // Force generation of code coverage
        $ifModifiedSinceConstruct = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        self::assertEquals($ifModifiedSince, $ifModifiedSinceConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructIfModifiedSinceWithEmptyDateFromValue(): void
    {
        $this->expectException(InvalidHeader::class);

        IfModifiedSince::fromValue('');
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfModifiedSinceFromValue(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $ifModifiedSinceFromValue = IfModifiedSince::fromValue('Sat, 03 Feb 2001 04:05:06 GMT');

        self::assertEquals($ifModifiedSince, $ifModifiedSinceFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfModifiedSinceToString(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('If-Modified-Since: Sat, 03 Feb 2001 04:05:06 GMT', (string)$ifModifiedSince);
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertTrue($ifModifiedSince->isValid()); // @phpstan-ignore-line
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('If-Modified-Since', $ifModifiedSince->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfModifiedSince(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertSame('Sat, 03 Feb 2001 04:05:06 GMT', $ifModifiedSince->getValue());
    }

    /**
     * @covers ::evaluate
     */
    public function testIfModifiedSinceEvaluatesToTrueWhenLastModifiedDateIsUnknown(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = null;

        self::assertTrue($ifModifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfModifiedSinceEvaluatesToFalseWhenLastModifiedDateIsEarlier(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2000-01-02 03:04:05'));

        self::assertFalse($ifModifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfModifiedSinceEvaluatesToFalseWhenLastModifiedDateIsTheSame(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($ifModifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfModifiedSinceEvaluatesToTrueWhenLastModifiedDateIsLater(): void
    {
        $ifModifiedSince = new IfModifiedSince(new Date(new DateTime('2001-02-03 04:05:06')));
        $lastModifiedDate = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertTrue($ifModifiedSince->evaluate($lastModifiedDate));
    }

    /**
     * @covers ::getDate
     */
    public function testCanGetDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));
        $ifModifiedSince = new IfModifiedSince($date);

        self::assertSame($date, $ifModifiedSince->getDate());
    }

    /**
     * @covers ::setDate
     */
    public function testCanSetDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));
        $ifModifiedSince = new IfModifiedSince($date);

        $ifModifiedSinceSetDate = new IfModifiedSince(new Date(new DateTime('2002-03-04 05:06:07')));
        $ifModifiedSinceSetDate->setDate($date);

        self::assertEquals($ifModifiedSince, $ifModifiedSinceSetDate);
    }
}
