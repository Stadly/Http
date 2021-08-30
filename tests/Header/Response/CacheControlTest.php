<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\CacheControl\FieldListDirective;
use Stadly\Http\Header\Value\CacheControl\GeneralDirective;
use Stadly\Http\Header\Value\CacheControl\IntegerDirective;
use Stadly\Http\Header\Value\CacheControl\ValuelessDirective;

/**
 * @coversDefaultClass \Stadly\Http\Header\Response\CacheControl
 * @covers ::<protected>
 * @covers ::<private>
 */
final class CacheControlTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructCacheControlWithoutDirectives(): void
    {
        $cacheControl = new CacheControl();

        // Force generation of code coverage
        $cacheControlConstruct = new CacheControl();
        self::assertEquals($cacheControl, $cacheControlConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructCacheControlWithSingleDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        // Force generation of code coverage
        $cacheControlConstruct = new CacheControl(new GeneralDirective('test', 'foo bar'));
        self::assertEquals($cacheControl, $cacheControlConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructCacheControlWithMultipleDirectives(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );

        // Force generation of code coverage
        $cacheControlConstruct = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );
        self::assertEquals($cacheControl, $cacheControlConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructCacheControlWithoutDirectivesFromValue(): void
    {
        $this->expectException(InvalidHeader::class);

        CacheControl::fromValue('');
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructCacheControlWithoutDirectivesFromValueWithWhitespace(): void
    {
        $this->expectException(InvalidHeader::class);

        CacheControl::fromValue(',,  , ,    ,    ');
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructCacheControlWithSingleDirectiveFromValue(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));
        $cacheControlFromValue = CacheControl::fromValue('test="foo bar"');

        self::assertEquals($cacheControl, $cacheControlFromValue);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructCacheControlWithSingleDirectiveFromValueWithWhitespace(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));
        $cacheControlFromValue = CacheControl::fromValue(', test="foo bar"   ,,  ,,');

        self::assertEquals($cacheControl, $cacheControlFromValue);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructCacheControlWithMultipleDirectivesFromValue(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );
        $cacheControlString = 'must-revalidate,no-cache="foo,bar",max-age=3600,foo,test="foo bar"';
        $cacheControlFromValue = CacheControl::fromValue($cacheControlString);

        self::assertEquals($cacheControl, $cacheControlFromValue);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructCacheControlWithMultipleDirectivesFromValueWithWhitespace(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );
        $cacheControlString = ',must-revalidate ,no-cache="foo, bar,, ",   max-age=3600,,,foo   ,test="foo bar" ,  ,';
        $cacheControlFromValue = CacheControl::fromValue($cacheControlString);

        self::assertEquals($cacheControl, $cacheControlFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCannotConvertCacheControlWithoutDirectivesToString(): void
    {
        $cacheControl = new CacheControl();

        $this->expectException(InvalidHeader::class);

        $cacheControl->__toString();
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertCacheControlWithSingleDirectiveToString(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('foo', 'foo bar'));

        self::assertSame('Cache-Control: foo="foo bar"', (string)$cacheControl);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertCacheControlWithMultipleDirectivesToString(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );

        self::assertSame(
            'Cache-Control: must-revalidate, no-cache="foo, bar", max-age=3600, foo, test="foo bar"',
            (string)$cacheControl
        );
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderWithoutDirectivesIsInvalid(): void
    {
        $cacheControl = new CacheControl();

        self::assertFalse($cacheControl->isValid());
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        self::assertTrue($cacheControl->isValid());
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $cacheControl = new CacheControl();

        self::assertSame('Cache-Control', $cacheControl->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithoutDirectives(): void
    {
        $cacheControl = new CacheControl();

        $this->expectException(InvalidHeader::class);

        $cacheControl->getValue();
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithSingleDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('foo', 'foo bar'));

        self::assertSame('foo="foo bar"', $cacheControl->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithMultipleDirectives(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );

        self::assertSame(
            'must-revalidate, no-cache="foo, bar", max-age=3600, foo, test="foo bar"',
            $cacheControl->getValue()
        );
    }

    /**
     * @covers ::hasDirective
     */
    public function testHasExistingDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        self::assertTrue($cacheControl->hasDirective('test'));
    }

    /**
     * @covers ::hasDirective
     */
    public function testDoesNotHaveNonExistingDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        self::assertFalse($cacheControl->hasDirective('foo'));
    }

    /**
     * @covers ::getDirective
     */
    public function testCanGetDirective(): void
    {
        $directive = new GeneralDirective('test', 'foo bar');
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        self::assertEquals($directive, $cacheControl->getDirective('test'));
    }

    /**
     * @covers ::getDirective
     */
    public function testCannotGetNonExistingDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        $this->expectException(OutOfBoundsException::class);

        $cacheControl->getDirective('foo');
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        $cacheControlSetDirective = new CacheControl();
        $cacheControlSetDirective->setDirective(new GeneralDirective('test', 'foo bar'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetExistingDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo'));

        $cacheControlSetDirective = new CacheControl(new GeneralDirective('test', 'foo bar'));
        $cacheControlSetDirective->setDirective(new GeneralDirective('test', 'foo'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetMultipleDirectives(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );

        $cacheControlSetDirective = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar')
        );
        $cacheControlSetDirective->setDirective(
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetValuelessDirective(): void
    {
        $cacheControl = new CacheControl(new ValuelessDirective('must-revalidate'));

        $cacheControlSetDirective = new CacheControl();
        $cacheControlSetDirective->setDirective(new ValuelessDirective('must-revalidate'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetFieldListDirective(): void
    {
        $cacheControl = new CacheControl(new FieldListDirective('no-cache', 'foo'));

        $cacheControlSetDirective = new CacheControl();
        $cacheControlSetDirective->setDirective(new FieldListDirective('no-cache', 'foo'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetIntegerDirective(): void
    {
        $cacheControl = new CacheControl(new IntegerDirective('max-age', '3600'));

        $cacheControlSetDirective = new CacheControl();
        $cacheControlSetDirective->setDirective(new IntegerDirective('max-age', '3600'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::setDirective
     */
    public function testCanSetGeneralDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        $cacheControlSetDirective = new CacheControl();
        $cacheControlSetDirective->setDirective(new GeneralDirective('test', 'foo bar'));

        self::assertEquals($cacheControl, $cacheControlSetDirective);
    }

    /**
     * @covers ::unsetDirective
     */
    public function testCanUnsetDirective(): void
    {
        $cacheControl = new CacheControl();

        $cacheControlUnsetDirective = new CacheControl(new GeneralDirective('test', 'foo bar'));
        $cacheControlUnsetDirective->unsetDirective('test');

        self::assertEquals($cacheControl, $cacheControlUnsetDirective);
    }

    /**
     * @covers ::unsetDirective
     */
    public function testCanUnsetNonExistingDirective(): void
    {
        $cacheControl = new CacheControl(new GeneralDirective('test', 'foo bar'));

        $cacheControlUnsetDirective = new CacheControl(new GeneralDirective('test', 'foo bar'));
        $cacheControlUnsetDirective->unsetDirective('foo');

        self::assertEquals($cacheControl, $cacheControlUnsetDirective);
    }

    /**
     * @covers ::unsetDirective
     */
    public function testCanUnsetMultipleDirectives(): void
    {
        $cacheControl = new CacheControl(
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600')
        );

        $cacheControlUnsetDirective = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );
        $cacheControlUnsetDirective->unsetDirective('must-revalidate', 'foo', 'test');

        self::assertEquals($cacheControl, $cacheControlUnsetDirective);
    }

    /**
     * @covers ::unsetDirective
     */
    public function testCanUnsetMultipleDirectivesWhereOneIsNonExisting(): void
    {
        $cacheControl = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new GeneralDirective('foo', null),
        );

        $cacheControlUnsetDirective = new CacheControl(
            new ValuelessDirective('must-revalidate'),
            new FieldListDirective('no-cache', 'foo', 'bar'),
            new IntegerDirective('max-age', '3600'),
            new GeneralDirective('foo', null),
            new GeneralDirective('test', 'foo bar')
        );
        $cacheControlUnsetDirective->unsetDirective('no-cache', 'max-age', 'qwerty', 'test');

        self::assertEquals($cacheControl, $cacheControlUnsetDirective);
    }
}
