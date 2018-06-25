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
    public function testCanConstructMediaType(): void
    {
        new MediaType('foo', 'bar');
        
        // Force generation of code coverage
        self::assertTrue(true);
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
    public function testCanConstructMediaTypeWithoutParametersFromString(): void
    {
        $mediaType = new MediaType('text', 'html');
        $mediaTypeFromString = MediaType::fromString('text/html');

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithSingleParameterFromString(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('charset', 'utf-8'));
        $mediaTypeFromString = MediaType::fromString('text/html;charset=utf-8');

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithSingleParameterFromStringWithWhitespace(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('charset', 'utf-8'));
        $mediaTypeFromString = MediaType::fromString("text/html\t ;  charset=utf-8");

        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithMultipleParametersFromString(): void
    {
        $mediaType = new MediaType(
            'text',
            'html',
            new Parameter('charset', 'utf-8'),
            new Parameter('boundary', 'abc def')
        );
        $mediaTypeFromString = MediaType::fromString('text/html;charset=utf-8;boundary="abc def"');
        
        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructMediaTypeWithMultipleParametersFromStringWithWhitespace(): void
    {
        $mediaType = new MediaType(
            'text',
            'html',
            new Parameter('charset', 'utf-8'),
            new Parameter('boundary', 'abc def')
        );
        $mediaTypeFromString = MediaType::fromString("text/html; \tcharset=utf-8  \t;  boundary=\"abc def\"");
        
        self::assertEquals($mediaType, $mediaTypeFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithoutParametersToString(): void
    {
        $mediaType = new MediaType('text', 'html');

        self::assertSame('text/html', (string)$mediaType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithSingleParameterToString(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('charset', 'utf-8'));

        self::assertSame('text/html; charset=utf-8', (string)$mediaType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertMediaTypeWithMultipleParametersToString(): void
    {
        $mediaType = new MediaType(
            'text',
            'html',
            new Parameter('charset', 'utf-8'),
            new Parameter('boundary', 'abc def')
        );

        self::assertSame('text/html; charset=utf-8; boundary="abc def"', (string)$mediaType);
    }

    /**
     * @covers ::getType
     */
    public function testCanGetType(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        self::assertSame('text', $mediaType->getType());
    }

    /**
     * @covers ::setType
     */
    public function testCanSetType(): void
    {
        $mediaType = new MediaType('multipart', 'html');
        
        $mediaTypeSetType = new MediaType('text', 'html');
        $mediaTypeSetType->setType('multipart');

        self::assertEquals($mediaType, $mediaTypeSetType);
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetEmptyType(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setType('');
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetInvalidType(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setType('f o o');
    }

    /**
     * @covers ::getSubtype
     */
    public function testCanGetSubtype(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        self::assertSame('html', $mediaType->getSubtype());
    }

    /**
     * @covers ::setSubtype
     */
    public function testCanSetSubtype(): void
    {
        $mediaType = new MediaType('text', 'form-data');

        $mediaTypeSetSubtype = new MediaType('text', 'html');
        $mediaTypeSetSubtype->setSubtype('form-data');

        self::assertEquals($mediaType, $mediaTypeSetSubtype);
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetEmptySubtype(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setSubtype('');
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetInvalidSubtype(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        $this->expectException(InvalidArgumentException::class);
        
        $mediaType->setSubtype('f o o');
    }

    /**
     * @covers ::hasParameter
     */
    public function testHasExistingParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        
        self::assertTrue($mediaType->hasParameter('foo'));
    }

    /**
     * @covers ::hasParameter
     */
    public function testDoesNotHaveNonExistingParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        
        self::assertFalse($mediaType->hasParameter('bar'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCanGetParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        $parameter = new Parameter('foo', 'bar');
        
        self::assertEquals($parameter, $mediaType->getParameter('foo'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCannotGetNonExistingParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        
        $this->expectException(OutOfBoundsException::class);
        
        $mediaType->getParameter('bar');
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        
        $mediaTypeSetParameter = new MediaType('text', 'html');
        $mediaTypeSetParameter->setParameter(new Parameter('foo', 'bar'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetExistingParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'foo'));
        
        $mediaTypeSetParameter = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        $mediaTypeSetParameter->setParameter(new Parameter('foo', 'foo'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetMultipleParameters(): void
    {
        $mediaType = new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        );
        
        $mediaTypeSetParameter = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        $mediaTypeSetParameter->setParameter(new Parameter('test', 'foo bar'), new Parameter('bar', 'foo'));

        self::assertEquals($mediaType, $mediaTypeSetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetParameter(): void
    {
        $mediaType = new MediaType('text', 'html');
        
        $mediaTypeUnsetParameter = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        $mediaTypeUnsetParameter->unsetParameter('foo');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCannotUnsetNonExistingParameter(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('foo', 'bar'));
        
        $this->expectException(OutOfBoundsException::class);
        
        $mediaType->unsetParameter('bar');
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParameters(): void
    {
        $mediaType = new MediaType('text', 'html', new Parameter('test', 'foo bar'));
        
        $mediaTypeUnsetParameter = new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        );
        $mediaTypeUnsetParameter->unsetParameter('foo', 'bar');

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testNothingIsUnsetWhenUnsettingMultipleParametersWhereOneIsNonExisting(): void
    {
        $mediaType = new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        );

        $mediaTypeUnsetParameter = new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        );
        try {
            $mediaTypeUnsetParameter->unsetParameter('foo', 'qwerty', 'bar');
        } catch (OutOfBoundsException $exception) {
            // 'qwerty' is not found.
        }

        self::assertEquals($mediaType, $mediaTypeUnsetParameter);
    }
}
