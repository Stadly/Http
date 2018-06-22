<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Exception\InvalidValue
 * @covers ::<protected>
 * @covers ::<private>
 */
final class InvalidValueTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructException(): void
    {
        new InvalidValue('foo');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $exception = new InvalidValue('foo');

        self::assertSame('foo', $exception->getValue());
    }
}
