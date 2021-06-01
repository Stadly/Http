<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\ContentDisposition\Parameter
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ParameterTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testCanConstructRegularParameterFromString(): void
    {
        $parameter = new RegularParameter('foo', 'bar');
        $parameterFromString = Parameter::fromString('foo=bar');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructExtendedParameterFromString(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');
        $parameterFromString = Parameter::fromString("foo*=UTF-8'en'bar");

        self::assertEquals($parameter, $parameterFromString);
    }
}
