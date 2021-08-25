<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\CacheControl\Directive
 * @covers ::<protected>
 * @covers ::<private>
 */
final class DirectiveTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testCanConstructFieldListDirectiveFromString(): void
    {
        $directive = new FieldListDirective('no-cache', 'foo', 'bar');
        $directiveFromString = Directive::fromString('no-cache="foo, bar"');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIntegerDirectiveFromString(): void
    {
        $directive = new IntegerDirective('max-age', '5');
        $directiveFromString = Directive::fromString('max-age=5');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructValuelessDirectiveFromString(): void
    {
        $directive = new ValuelessDirective('no-store');
        $directiveFromString = Directive::fromString('no-store');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructGeneralDirectiveFromString(): void
    {
        $directive = new GeneralDirective('foo', 'bar');
        $directiveFromString = Directive::fromString('foo=bar');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Directive::fromString('f o o');
    }
}
