<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Exception\InvalidName
 * @covers ::<protected>
 * @covers ::<private>
 */
final class InvalidNameTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructException(): void
    {
        new InvalidName('foo');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $Exception = new InvalidName('foo');

        self::assertSame('foo', $Exception->getName());
    }
}
