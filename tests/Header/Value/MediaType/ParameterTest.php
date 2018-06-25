<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\MediaType;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\MediaType\Parameter
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ParameterTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructParameter(): void
    {
        new Parameter('foo', 'bar');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Parameter('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Parameter('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructParameterWithEmptyValue(): void
    {
        new Parameter('foo', '');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Parameter('foo', '€-rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterFromString(): void
    {
        $parameter = new Parameter('foo', 'bar');
        $parameterFromString = Parameter::fromString('foo=bar');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructQuotedParameterFromString(): void
    {
        $parameter = new Parameter('foo', 'b a r');
        $parameterFromString = Parameter::fromString('foo="b a r"');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('f o o=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterWithEmptyQuotedValueFromString(): void
    {
        $parameter = new Parameter('foo', '');
        $parameterFromString = Parameter::fromString('foo=""');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('foo=€-rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidQuotedValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('foo="€-rate"');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Parameter::fromString('foo');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertParameterToString(): void
    {
        $parameter = new Parameter('foo', 'bar');

        self::assertSame('foo=bar', (string)$parameter);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertQuotedParameterToString(): void
    {
        $parameter = new Parameter('foo', 'b a r');

        self::assertSame('foo="b a r"', (string)$parameter);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $parameter = new Parameter('foo', 'bar');
        
        self::assertSame('foo', $parameter->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $parameter = new Parameter('baz', 'bar');
        
        $parameterSetName = new Parameter('foo', 'bar');
        $parameterSetName->setName('baz');

        self::assertEquals($parameter, $parameterSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $parameter = new Parameter('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $parameter->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $parameter = new Parameter('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $parameter->setName('f o o');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $parameter = new Parameter('foo', 'bar');
        
        self::assertSame('bar', $parameter->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $parameter = new Parameter('foo', 'baz');

        $parameterSetValue = new Parameter('foo', 'bar');
        $parameterSetValue->setValue('baz');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $parameter = new Parameter('foo', '');

        $parameterSetValue = new Parameter('foo', 'bar');
        $parameterSetValue->setValue('');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $parameter = new Parameter('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $parameter->setValue('€-rate');
    }
}
