<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\ContentDisposition\ExtendedParameter
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ExtendedParameterTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructParameter(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');

        // Force generation of code coverage
        $parameterConstruct = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructParameterWithNonAsciiValue(): void
    {
        $parameter = new ExtendedParameter('foo*', '€ rate');

        // Force generation of code coverage
        $parameterConstruct = new ExtendedParameter('foo*', '€ rate');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructParameterWithEmptyValue(): void
    {
        $parameter = new ExtendedParameter('foo*', '');

        // Force generation of code coverage
        $parameterConstruct = new ExtendedParameter('foo*', '');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', '€ rate', 'ASCII');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithEmptyCharset(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', 'bar', '');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidCharset(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', 'bar', 'UTF 8');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithUnsupportedCharset(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', 'bar', 'QWERTY');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithIncompatibleCharset(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', '€ rate', 'ASCII');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructParameterWithEmptyLanguage(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', '');

        // Force generation of code coverage
        $parameterConstruct = new ExtendedParameter('foo*', 'bar', 'UTF-8', '');
        self::assertEquals($parameter, $parameterConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructParameterWithInvalidLanguage(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ExtendedParameter('foo*', 'bar', 'UTF-8', '€ rate');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterFromString(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');
        $parameterFromString = ExtendedParameter::fromString("foo*=UTF-8'en'bar");

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("*=''bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("f o o*=''bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterWithNonAsciiValueFromString(): void
    {
        $parameter = new ExtendedParameter('foo*', '€ rate', 'UTF-8');
        $parameterFromString = ExtendedParameter::fromString("foo*=UTF-8''%E2%82%AC%20rate");

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterWithEmptyValueFromString(): void
    {
        $parameter = new ExtendedParameter('foo*', '', 'UTF-8');
        $parameterFromString = ExtendedParameter::fromString("foo*=UTF-8''");

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=ASCII''€ rate");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString('foo*');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithEmptyCharsetFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=''bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidCharsetFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=UTF 8''bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithUnsupportedCharsetFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=QWERTY''bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithIncompatibleCharsetFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=ASCII''€ rate");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructParameterWithEmptyLanguageFromString(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', '');
        $parameterFromString = ExtendedParameter::fromString("foo*=UTF-8''bar");

        self::assertEquals($parameter, $parameterFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructParameterWithInvalidLanguageFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ExtendedParameter::fromString("foo*=UTF-8'€ rate'bar");
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertParameterToString(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');

        self::assertSame("foo*=UTF-8'en'bar", (string)$parameter);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertParameterWithNonAsciiValueToString(): void
    {
        $parameter = new ExtendedParameter('foo*', '€ rate', 'UTF-8', 'en');

        self::assertSame("foo*=UTF-8'en'%E2%82%AC%20rate", (string)$parameter);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        self::assertSame('foo*', $parameter->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $parameter = new ExtendedParameter('baz*', 'bar');

        $parameterSetName = new ExtendedParameter('foo*', 'bar');
        $parameterSetName->setName('baz*');

        self::assertEquals($parameter, $parameterSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setName('*');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setName('€ rate*');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        self::assertSame('bar', $parameter->getValue());
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetValue(): void
    {
        $parameter = new ExtendedParameter('foo*', 'baz');

        $parameterSetValue = new ExtendedParameter('foo*', 'bar');
        $parameterSetValue->setValue('baz');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCanSetEmptyValue(): void
    {
        $parameter = new ExtendedParameter('foo*', '');

        $parameterSetValue = new ExtendedParameter('foo*', 'bar');
        $parameterSetValue->setValue('');

        self::assertEquals($parameter, $parameterSetValue);
    }

    /**
     * @covers ::setValue
     */
    public function testCannotSetInvalidValue(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'ASCII');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setValue('€ rate');
    }

    /**
     * @covers ::getCharset
     */
    public function testCanGetCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'ASCII');

        self::assertSame('ASCII', $parameter->getCharset());
    }

    /**
     * @covers ::setCharset
     */
    public function testCanSetCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'ASCII');

        $parameterSetCharset = new ExtendedParameter('foo*', 'bar', 'UTF-8');
        $parameterSetCharset->setCharset('ASCII');

        self::assertEquals($parameter, $parameterSetCharset);
    }

    /**
     * @covers ::setCharset
     */
    public function testCannotSetEmptyCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setCharset('');
    }

    /**
     * @covers ::setCharset
     */
    public function testCannotSetInvalidCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setCharset('UTF 8');
    }

    /**
     * @covers ::setCharset
     */
    public function testCannotSetUnsupportedCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setCharset('QWERTY');
    }

    /**
     * @covers ::setCharset
     */
    public function testCannotSetIncompatibleCharset(): void
    {
        $parameter = new ExtendedParameter('foo*', '€ rate');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setCharset('ASCII');
    }

    /**
     * @covers ::getLanguage
     */
    public function testCanGetLanguage(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');

        self::assertSame('en', $parameter->getLanguage());
    }

    /**
     * @covers ::setLanguage
     */
    public function testCanSetLanguage(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'de');

        $parameterSetLanguage = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');
        $parameterSetLanguage->setLanguage('de');

        self::assertEquals($parameter, $parameterSetLanguage);
    }

    /**
     * @covers ::setLanguage
     */
    public function testCanSetEmptyLanguage(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', '');

        $parameterSetLanguage = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');
        $parameterSetLanguage->setLanguage('');

        self::assertEquals($parameter, $parameterSetLanguage);
    }

    /**
     * @covers ::setLanguage
     */
    public function testCannotSetInvalidLanguage(): void
    {
        $parameter = new ExtendedParameter('foo*', 'bar', 'UTF-8', 'en');

        $this->expectException(InvalidArgumentException::class);

        $parameter->setLanguage('€ rate');
    }
}
