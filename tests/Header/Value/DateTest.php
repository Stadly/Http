<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\Date
 * @covers ::<protected>
 * @covers ::<private>
 */
final class DateTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));

        // Force generation of code coverage
        $dateConstruct = new Date(new DateTime('2001-02-03 04:05:06'));
        self::assertEquals($date, $dateConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructStrongDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);

        // Force generation of code coverage
        $dateConstruct = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);
        self::assertEquals($date, $dateConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDateWithNamedTimeZone(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateTimeZone = new Date(new DateTime('2001-02-02 23:05:06', new DateTimeZone('EST')));

        self::assertEquals($date, $dateTimeZone);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDateWithRelativeTimeZone(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateTimeZone = new Date(new DateTime('2001-02-03 02:05:06', new DateTimeZone('-02:00')));

        self::assertEquals($date, $dateTimeZone);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDateWithLocationBasedTimeZone(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateTimeZone = new Date(new DateTime('2001-02-03 11:05:06', new DateTimeZone('Indian/Christmas')));

        self::assertEquals($date, $dateTimeZone);
    }

    /**
     * @covers ::__construct
     */
    public function testMicrosecondsAreDiscardedWhenConstructingDate(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));
        $dateMicroseconds = new Date(new DateTime('2001-02-03 04:05:06.789'));

        self::assertEquals($date, $dateMicroseconds);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromTimestamp(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(981173106);

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructStrongDateFromTimestamp(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')), /*isWeak*/false);
        $dateFromTimestamp = Date::fromTimestamp(981173106, /*isWeak*/false);

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromZeroTimestamp(): void
    {
        $date = new Date(new DateTime('1970-01-01 00:00:00', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(0);

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromTheSmallest32BitTimestamp(): void
    {
        $date = new Date(new DateTime('1901-12-13 20:45:52', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(-2147483648); // The smallest 32-bit integer (-2^31).

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromTheLargest32BitTimestamp(): void
    {
        $date = new Date(new DateTime('2038-01-19 03:14:07', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(2147483647); // The largest 32-bit integer (2^31-1).

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromTheSmallerThan32BitTimestamp(): void
    {
        $date = new Date(new DateTime('1000-01-01 00:00:00', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(-30610224000); // Smaller than any 32-bit integer.

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromTimestamp
     */
    public function testCanConstructDateFromTheLargerThan32BitTimestamp(): void
    {
        $date = new Date(new DateTime('3000-01-01 00:00:00', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(32503680000); // Larger than any 32-bit integer.

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::__construct
     */
    public function testMicrosecondsAreDiscardedWhenConstructingDateFromTimestamp(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateFromTimestamp = Date::fromTimestamp(981173106.789);

        self::assertEquals($date, $dateFromTimestamp);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDateFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Date::fromString('');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDateFromMalformedString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Date::fromString('2001-02-03 04:05:06');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDateFromImfFixdateFormattedString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateFromString = Date::fromString('Sat, 03 Feb 2001 04:05:06 GMT');

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDateFromRfc850FormattedString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateFromString = Date::fromString('Saturday, 03-Feb-01 04:05:06 GMT');

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString200YearsInTheFutureIsInterpretedAsNow(): void
    {
        $dateTime = new DateTimeImmutable('+200 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('-200 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString150YearsInTheFutureIsInterpretedAs50YearsInTheFuture(): void
    {
        $dateTime = new DateTimeImmutable('+150 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('-100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString100YearsInTheFutureIsInterpretedAsNow(): void
    {
        $dateTime = new DateTimeImmutable('+100 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('-100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString51YearsInTheFutureIsInterpretedAs49YearsInThePast(): void
    {
        $dateTime = new DateTimeImmutable('+51 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('-100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString50YearsInTheFutureIsInterpretedAs50YearsInTheFuture(): void
    {
        $dateTime = new DateTime('+50 years', new DateTimeZone('GMT'));

        $date = new Date($dateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString49YearsInTheFutureIsInterpretedAs49YearsInTheFuture(): void
    {
        $dateTime = new DateTime('+49 years', new DateTimeZone('GMT'));

        $date = new Date($dateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString49YearsInThePastIsInterpretedAs49YearsInThePast(): void
    {
        $dateTime = new DateTimeImmutable('-49 years', new DateTimeZone('GMT'));

        $date = new Date($dateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString50YearsInThePastIsInterpretedAs50YearsInTheFuture(): void
    {
        $dateTime = new DateTimeImmutable('-50 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('+100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString51YearsInThePastIsInterpretedAs49YearsInTheFuture(): void
    {
        $dateTime = new DateTimeImmutable('-51 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('+100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString100YearsInThePastIsInterpretedAsNow(): void
    {
        $dateTime = new DateTimeImmutable('-100 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('+100 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString150YearsInThePastIsInterpretedAs50YearsInTheFuture(): void
    {
        $dateTime = new DateTimeImmutable('-150 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('+200 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testRfc850FormattedString200YearsInThePastIsInterpretedAsNow(): void
    {
        $dateTime = new DateTimeImmutable('-200 years', new DateTimeZone('GMT'));
        $interpretedDateTime = $dateTime->modify('+200 years');

        $date = new Date($interpretedDateTime);
        $dateFromString = Date::fromString($dateTime->format('l, d-M-y H:i:s T'));

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDateFromAsctimeFormattedString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));
        $dateFromString = Date::fromString('Sat Feb  3 04:05:06 2001');

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructStrongDateFromString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')), /*isWeak*/false);
        $dateFromString = Date::fromString('Sat, 03 Feb 2001 04:05:06 GMT', /*isWeak*/false);

        self::assertEquals($date, $dateFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDateToString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')));

        self::assertSame('Sat, 03 Feb 2001 04:05:06 GMT', (string)$date);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertStrongDateToString(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06', new DateTimeZone('GMT')), /*isWeak*/false);

        self::assertSame('Sat, 03 Feb 2001 04:05:06 GMT', (string)$date);
    }

    /**
     * @covers ::isWeak
     */
    public function testWeakDateIsWeak(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date->isWeak());
    }

    /**
     * @covers ::isWeak
     */
    public function testStrongDateIsNotWeak(): void
    {
        $date = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);

        self::assertFalse($date->isWeak());
    }

    /**
     * @covers ::isLt
     */
    public function testDateIsLessThanLaterDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertTrue($date1->isLt($date2));
    }

    /**
     * @covers ::isLt
     */
    public function testDateIsNotLessThanSameDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($date1->isLt($date2));
    }

    /**
     * @covers ::isLt
     */
    public function testDateIsNotLessThanEarlierDate(): void
    {
        $date1 = new Date(new DateTime('2002-03-04 05:06:07'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($date1->isLt($date2));
    }

    /**
     * @covers ::isLte
     */
    public function testDateIsLessThanOrEqualToLaterDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertTrue($date1->isLte($date2));
    }

    /**
     * @covers ::isLte
     */
    public function testDateIsLessThanOrEqualToSameDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date1->isLte($date2));
    }

    /**
     * @covers ::isLte
     */
    public function testDateIsNotLessThanOrEqualToEarlierDate(): void
    {
        $date1 = new Date(new DateTime('2002-03-04 05:06:07'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($date1->isLte($date2));
    }

    /**
     * @covers ::isEq
     */
    public function testDateIsNotEqualToLaterDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertFalse($date1->isEq($date2));
    }

    /**
     * @covers ::isEq
     */
    public function testDateIsEqualToSameDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date1->isEq($date2));
    }

    /**
     * @covers ::isEq
     */
    public function testDateIsNotEqualToEarlierDate(): void
    {
        $date1 = new Date(new DateTime('2002-03-04 05:06:07'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($date1->isEq($date2));
    }

    /**
     * @covers ::isGte
     */
    public function testDateIsNotGreaterThanOrEqualToLaterDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertFalse($date1->isGte($date2));
    }

    /**
     * @covers ::isGte
     */
    public function testDateIsGreaterThanOrEqualToSameDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date1->isGte($date2));
    }

    /**
     * @covers ::isGte
     */
    public function testDateIsGreaterThanOrEqualToEarlierDate(): void
    {
        $date1 = new Date(new DateTime('2002-03-04 05:06:07'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date1->isGte($date2));
    }

    /**
     * @covers ::isGt
     */
    public function testDateIsNotGreaterThanLaterDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2002-03-04 05:06:07'));

        self::assertFalse($date1->isGt($date2));
    }

    /**
     * @covers ::isGt
     */
    public function testDateIsNotGreaterThanSameDate(): void
    {
        $date1 = new Date(new DateTime('2001-02-03 04:05:06'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($date1->isGt($date2));
    }

    /**
     * @covers ::isGt
     */
    public function testDateIsGreaterThanEarlierDate(): void
    {
        $date1 = new Date(new DateTime('2002-03-04 05:06:07'));
        $date2 = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertTrue($date1->isGt($date2));
    }
}
