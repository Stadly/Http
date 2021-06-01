<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\ContentDisposition\RegularParameter
 * @covers ::<protected>
 * @covers ::<private>
 */
final class RegularParameterTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructParameter(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        // Force generation of code coverage
        $parameterConstruct = new RegularParameter('foo', 'bar');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructQuotedParameter(): void
    {
        $parameter = new RegularParameter('foo', 'b a r');

        // Force generation of code coverage
        $parameterConstruct = new RegularParameter('foo', 'b a r');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new RegularParameter('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new RegularParameter('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructParameterWithEmptyValue(): void
    {
        $parameter = new RegularParameter('foo', '');

        // Force generation of code coverage
        $parameterConstruct = new RegularParameter('foo', '');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new RegularParameter('foo', '€ rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterFromString(): void
    {
        $parameter = new RegularParameter('foo', 'bar');
        $parameterFromString = RegularParameter::fromString('foo=bar');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructQuotedParameterFromString(): void
    {
        $parameter = new RegularParameter('foo', 'b a r');
        $parameterFromString = RegularParameter::fromString('foo="b a r"');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('f o o=bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterWithEmptyQuotedValueFromString(): void
    {
        $parameter = new RegularParameter('foo', '');
        $parameterFromString = RegularParameter::fromString('foo=""');

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('foo=€ rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidQuotedValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('foo="€ rate"');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RegularParameter::fromString('foo');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertParameterToString(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        self::assertSame('foo=bar', (string)$parameter);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertQuotedParameterToString(): void
    {
        $parameter = new RegularParameter('foo', 'b a r');

        self::assertSame('foo="b a r"', (string)$parameter);
    }

    /**
     * @covers \Stadly\Http\Header\Value\ContentDisposition\RegularParameter::getName
     */
    public function testCanGetName(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        self::assertSame('foo', $parameter->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $parameter = new RegularParameter('baz', 'bar');

        $parameterSetValue = new RegularParameter('foo', 'bar');
        $parameterSetValue->setName('baz');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setName('€ rate');
    }

    /**
     * @covers \Stadly\Http\Header\Value\ContentDisposition\RegularParameter::getValue
     */
    public function testCanGetValue(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        self::assertSame('bar', $parameter->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $parameter = new RegularParameter('foo', 'baz');

        $parameterSetValue = new RegularParameter('foo', 'bar');
        $parameterSetValue->setValue('baz');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $parameter = new RegularParameter('foo', '');

        $parameterSetValue = new RegularParameter('foo', 'bar');
        $parameterSetValue->setValue('');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $parameter = new RegularParameter('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setValue('€ rate');
    }
}
