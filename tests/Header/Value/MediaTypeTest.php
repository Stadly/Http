<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use InvalidArgumentException;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\MediaType\Parameter;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\MediaType
 * @covers ::<protected>
 * @covers ::<private>
 */
final class MediaTypeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructMediaTypeWithoutParameters(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        // Force generation of code coverage
        $mediaTypeConstruct = new MediaType('foo', 'bar');
        self::assertEquals($mediaType, $mediaTypeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructMediaTypeWithSingleParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        // Force generation of code coverage
        $mediaTypeConstruct = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        self::assertEquals($mediaType, $mediaTypeConstruct);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithMultipleParameters(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3')
        );
        
        // Force generation of code coverage
        $mediaTypeConstruct = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3')
        );
        self::assertEquals($mediaType, $mediaTypeConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructMediaTypeWithEmptyType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MediaType('', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructMediaTypeWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MediaType('f o o', 'bar');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructMediaTypeWithEmptySubtype(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MediaType('foo', '');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructMediaTypeWithInvalidSubtype(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MediaType('foo', 'b a r');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithoutParametersFromString(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        $mediaTypeFromString = MediaType::fromString('foo/bar');

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithSingleParameterFromString(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeFromString = MediaType::fromString('foo/bar;baz=test');

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithSingleParameterFromStringWithWhitespace(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeFromString = MediaType::fromString("foo/bar\t ;  baz=test");

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithMultipleParametersFromString(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3')
        );
        $mediaTypeFromString = MediaType::fromString('foo/bar;baz=test;qwerty="1 2 3"');
        
        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithMultipleParametersFromStringWithWhitespace(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3')
        );
        $mediaTypeFromString = MediaType::fromString("foo/bar; \tbaz=test  \t;  qwerty=\"1 2 3\"");
        
        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructMediaTypeWithEmptyTypeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        MediaType::fromString('/bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructMediaTypeWithInvalidTypeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        MediaType::fromString('f o o/bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructMediaTypeWithEmptySubtypeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        MediaType::fromString('foo/');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructMediaTypeWithInvalidSubtypeFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        MediaType::fromString('foo/b a r');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructMediaTypeWithInvalidParameterFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        MediaType::fromString('foo/bar; foo=€-rate');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithoutParametersToString(): void
    {
        $mediaType = new MediaType('foo', 'bar');

        self::assertSame('foo/bar', (string)$mediaType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithSingleParameterToString(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));

        self::assertSame('foo/bar; baz=test', (string)$mediaType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithMultipleParametersToString(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3')
        );

        self::assertSame('foo/bar; baz=test; qwerty="1 2 3"', (string)$mediaType);
    }

    /**
     * @covers ::getType
     */
    public function testCanGetType(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        self::assertSame('foo', $mediaType->getType());
    }

    /**
     * @covers ::setType
     */
    public function testCanSetType(): void
    {
        $mediaType = new MediaType('xyzzy', 'bar');
        
        $mediaTypeSetType = new MediaType('foo', 'bar');
        $mediaTypeSetType->setType('xyzzy');

        self::assertEquals($mediaType, $mediaTypeSetType);
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetEmptyType(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setType('');
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetInvalidType(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setType('f o o');
    }

    /**
     * @covers ::getSubtype
     */
    public function testCanGetSubtype(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        self::assertSame('bar', $mediaType->getSubtype());
    }

    /**
     * @covers ::setSubtype
     */
    public function testCanSetSubtype(): void
    {
        $mediaType = new MediaType('foo', 'xyzzy');

        $mediaTypeSetSubtype = new MediaType('foo', 'bar');
        $mediaTypeSetSubtype->setSubtype('xyzzy');

        self::assertEquals($mediaType, $mediaTypeSetSubtype);
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetEmptySubtype(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setSubtype('');
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetInvalidSubtype(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setSubtype('f o o');
    }

    /**
     * @covers ::hasParameter
     */
    public function testHasExistingParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        self::assertTrue($mediaType->hasParameter('baz'));
    }

    /**
     * @covers ::hasParameter
     */
    public function testDoesNotHaveNonExistingParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        self::assertFalse($mediaType->hasParameter('qwert'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCanGetParameter(): void
    {
        $parameter = new Parameter('baz', 'test');
        $mediaType = new MediaType('foo', 'bar', $parameter);
        
        self::assertSame($parameter, $mediaType->getParameter('baz'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCannotGetNonExistingParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        $this->expectException(OutOfBoundsException::class);
        
        $mediaType->getParameter('qwerty');
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        $mediaTypeSetParameter = new MediaType('foo', 'bar');
        $mediaTypeSetParameter->setParameter(new Parameter('baz', 'test'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetExistingParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'asdf'));
        
        $mediaTypeSetParameter = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeSetParameter->setParameter(new Parameter('baz', 'asdf'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetMultipleParameters(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3'),
            new Parameter('xyzzy', 'asdf')
        );
        
        $mediaTypeSetParameter = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeSetParameter->setParameter(new Parameter('qwerty', '1 2 3'), new Parameter('xyzzy', 'asdf'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar');
        
        $mediaTypeUnsetParameter = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeUnsetParameter->unsetParameter('baz');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetNonExistingParameter(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        
        $mediaTypeUnsetParameter = new MediaType('foo', 'bar', new Parameter('baz', 'test'));
        $mediaTypeUnsetParameter->unsetParameter('fum');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParameters(): void
    {
        $mediaType = new MediaType('foo', 'bar', new Parameter('qwerty', '1 2 3'));
        
        $mediaTypeUnsetParameter = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3'),
            new Parameter('xyzzy', 'asdf')
        );
        $mediaTypeUnsetParameter->unsetParameter('baz', 'xyzzy');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParametersWhereOneIsNonExisting(): void
    {
        $mediaType = new MediaType(
            'foo',
            'bar',
            new Parameter('qwerty', '1 2 3')
        );

        $mediaTypeUnsetParameter = new MediaType(
            'foo',
            'bar',
            new Parameter('baz', 'test'),
            new Parameter('qwerty', '1 2 3'),
            new Parameter('xyzzy', 'asdf')
        );
        $mediaTypeUnsetParameter->unsetParameter('baz', 'fum', 'xyzzy');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }
}
