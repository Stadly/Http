<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Exception\InvalidFormat
 * @covers ::<protected>
 * @covers ::<private>
 */
final class InvalidFormatTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructException(): void
    {
        new InvalidFormat('foo');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::getHeader
     */
    public function testCanGetHeader(): void
    {
        $exception = new InvalidFormat('foo');

        self::assertSame('foo', $exception->getHeader());
    }
}
