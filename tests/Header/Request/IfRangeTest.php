<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use DateTime;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Date;
use Stadly\Http\Header\Value\EntityTag\EntityTag;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\IfRange
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IfRangeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructIfRangeWithEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));

        // Force generation of code coverage
        $ifRangeConstruct = new IfRange(new EntityTag('foo'));
        self::assertEquals($ifRange, $ifRangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfRangeWithWeakEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo', /*isWeak*/true));

        // Force generation of code coverage
        $ifRangeConstruct = new IfRange(new EntityTag('foo', /*isWeak*/true));
        self::assertEquals($ifRange, $ifRangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfRangeWithDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));

        // Force generation of code coverage
        $ifRangeConstruct = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        self::assertEquals($ifRange, $ifRangeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfRangeWithWeakDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06')));

        // Force generation of code coverage
        $ifRangeConstruct = new IfRange(new Date(new DateTime('2001-02-03 04:05:06')));
        self::assertEquals($ifRange, $ifRangeConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructIfRangeWithEmptyValidatorFromValue(): void
    {
        $this->expectException(InvalidHeader::class);

        IfRange::fromValue('');
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfRangeWithEntityTagFromValue(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $ifRangeFromValue = IfRange::fromValue('"foo"');

        self::assertEquals($ifRange, $ifRangeFromValue);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfRangeWithWeakEntityTagFromValue(): void
    {
        $ifRange = new IfRange(new EntityTag('foo', /*isWeak*/true));
        $ifRangeFromValue = IfRange::fromValue('W/"foo"');

        self::assertEquals($ifRange, $ifRangeFromValue);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfRangeWithDateFromValue(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $ifRangeFromValue = IfRange::fromValue('Sat, 03 Feb 2001 04:05:06 GMT');

        self::assertEquals($ifRange, $ifRangeFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfRangeWithEntityTagToString(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));

        self::assertSame('If-Range: "foo"', (string)$ifRange);
    }

    /**
     * @covers ::__toString
     */
    public function testCannotConvertIfRangeWithWeakEntityTagToString(): void
    {
        $ifRange = new IfRange(new EntityTag('foo', /*isWeak*/true));

        $this->expectException(InvalidHeader::class);

        $ifRange->__toString();
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfRangeWithDateToString(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));

        self::assertSame('If-Range: Sat, 03 Feb 2001 04:05:06 GMT', (string)$ifRange);
    }

    /**
     * @covers ::__toString
     */
    public function testCannotConvertIfRangeWithWeakDateToString(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06')));

        $this->expectException(InvalidHeader::class);

        $ifRange->__toString();
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderWithEntityTagIsValid(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));

        self::assertTrue($ifRange->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderWithWeakEntityTagIsInvalid(): void
    {
        $ifRange = new IfRange(new EntityTag('foo', /*isWeak*/true));

        self::assertFalse($ifRange->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderWithDateIsValid(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));

        self::assertTrue($ifRange->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderWithWeakDateIsInvalid(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06')));

        self::assertFalse($ifRange->isValid());
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));

        self::assertSame('If-Range', $ifRange->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfRangeWithEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));

        self::assertSame('"foo"', $ifRange->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCannotGetValueForIfRangeWithWeakEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo', /*isWeak*/true));

        $this->expectException(InvalidHeader::class);

        $ifRange->getValue();
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfRangeWithDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));

        self::assertSame('Sat, 03 Feb 2001 04:05:06 GMT', $ifRange->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCannotGetValueForIfRangeWithWeakDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06')));

        $this->expectException(InvalidHeader::class);

        $ifRange->getValue();
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithEntityTagEvaluatesToFalseWhenValidatorIsUnknown(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $validator = null;

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithEntityTagEvaluatesToFalseWhenValidatorIsOtherEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $validator = new EntityTag('bar');

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithEntityTagEvaluatesToTrueWhenValidatorIsSameEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $validator = new EntityTag('foo');

        self::assertTrue($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithEntityTagEvaluatesToFalseWhenValidatorIsWeakEntityTag(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $validator = new EntityTag('foo', /*isWeak*/true);

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithEntityTagEvaluatesToFalseWhenValidatorIsDate(): void
    {
        $ifRange = new IfRange(new EntityTag('foo'));
        $validator = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToFalseWhenValidatorIsUnknown(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = null;

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToFalseWhenValidatorIsEarlierDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = new Date(new DateTime('2000-01-02 03:04:05'), /*isWeak*/false);

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToTrueWhenValidatorIsSameDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);

        self::assertTrue($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToFalseWhenValidatorIsLaterDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = new Date(new DateTime('2002-03-04 05:06:07'), /*isWeak*/false);

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToFalseWhenValidatorIsWeakDate(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = new Date(new DateTime('2001-02-03 04:05:06'));

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::evaluate
     */
    public function testIfRangeWithDateEvaluatesToFalseWhenValidatorIsEntityTag(): void
    {
        $ifRange = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $validator = new EntityTag('foo');

        self::assertFalse($ifRange->evaluate($validator));
    }

    /**
     * @covers ::getValidator
     */
    public function testCanGetValidator(): void
    {
        $validator = new EntityTag('foo');
        $ifRange = new IfRange($validator);

        self::assertSame($validator, $ifRange->getValidator());
    }

    /**
     * @covers ::setValidator
     */
    public function testCanSetValidatorToEntityTag(): void
    {
        $validator = new EntityTag('foo');
        $ifRange = new IfRange($validator);

        $ifRangeSetValidator = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $ifRangeSetValidator->setValidator($validator);

        self::assertEquals($ifRange, $ifRangeSetValidator);
    }

    /**
     * @covers ::setValidator
     */
    public function testCanSetValidatorToWeakEntityTag(): void
    {
        $validator = new EntityTag('foo', /*isWeak*/true);
        $ifRange = new IfRange($validator);

        $ifRangeSetValidator = new IfRange(new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false));
        $ifRangeSetValidator->setValidator($validator);

        self::assertEquals($ifRange, $ifRangeSetValidator);
    }

    /**
     * @covers ::setValidator
     */
    public function testCanSetValidatorToDate(): void
    {
        $validator = new Date(new DateTime('2001-02-03 04:05:06'), /*isWeak*/false);
        $ifRange = new IfRange($validator);

        $ifRangeSetValidator = new IfRange(new EntityTag('foo'));
        $ifRangeSetValidator->setValidator($validator);

        self::assertEquals($ifRange, $ifRangeSetValidator);
    }

    /**
     * @covers ::setValidator
     */
    public function testCanSetValidatorToWeakDate(): void
    {
        $validator = new Date(new DateTime('2001-02-03 04:05:06'));
        $ifRange = new IfRange($validator);

        $ifRangeSetValidator = new IfRange(new EntityTag('foo'));
        $ifRangeSetValidator->setValidator($validator);

        self::assertEquals($ifRange, $ifRangeSetValidator);
    }
}
