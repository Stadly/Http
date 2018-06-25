<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\MediaType;
use Stadly\Http\Header\Value\MediaType\Parameter;

/**
 * @coversDefaultClass \Stadly\Http\Header\Common\ContentType
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ContentTypeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructContentType(): void
    {
        new ContentType(new MediaType('text', 'html'));
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentTypeWithoutParametersToString(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));

        self::assertSame('Content-Type: text/html', (string)$contentType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentTypeWithSingleParameterToString(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('charset', 'utf-8')));

        self::assertSame('Content-Type: text/html; charset=utf-8', (string)$contentType);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentTypeWithMultipleParametersToString(): void
    {
        $contentType = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('charset', 'utf-8'),
            new Parameter('boundary', 'abc def')
        ));

        self::assertSame('Content-Type: text/html; charset=utf-8; boundary="abc def"', (string)$contentType);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));

        self::assertSame('Content-Type', $contentType->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentTypeWithoutParameters(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));

        self::assertSame('text/html', $contentType->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentTypeWithSingleParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('charset', 'utf-8')));

        self::assertSame('text/html; charset=utf-8', $contentType->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentTypeWithMultipleParameters(): void
    {
        $contentType = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('charset', 'utf-8'),
            new Parameter('boundary', 'abc def')
        ));

        self::assertSame('text/html; charset=utf-8; boundary="abc def"', $contentType->getValue());
    }

    /**
     * @covers ::getType
     */
    public function testCanGetType(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        self::assertSame('text', $contentType->getType());
    }

    /**
     * @covers ::setType
     */
    public function testCanSetType(): void
    {
        $contentType = new ContentType(new MediaType('multipart', 'html'));
        
        $contentTypeSetType = new ContentType(new MediaType('text', 'html'));
        $contentTypeSetType->setType('multipart');

        self::assertEquals($contentType, $contentTypeSetType);
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetEmptyType(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        $this->expectException(InvalidArgumentException::class);
        
        $contentType->setType('');
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetInvalidType(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        $this->expectException(InvalidArgumentException::class);
        
        $contentType->setType('f o o');
    }

    /**
     * @covers ::getSubtype
     */
    public function testCanGetSubtype(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        self::assertSame('html', $contentType->getSubtype());
    }

    /**
     * @covers ::setSubtype
     */
    public function testCanSetSubtype(): void
    {
        $contentType = new ContentType(new MediaType('text', 'form-data'));

        $contentTypeSetSubtype = new ContentType(new MediaType('text', 'html'));
        $contentTypeSetSubtype->setSubtype('form-data');

        self::assertEquals($contentType, $contentTypeSetSubtype);
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetEmptySubtype(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        $this->expectException(InvalidArgumentException::class);
        
        $contentType->setSubtype('');
    }

    /**
     * @covers ::setSubtype
     */
    public function testCannotSetInvalidSubtype(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        $this->expectException(InvalidArgumentException::class);
        
        $contentType->setSubtype('f o o');
    }

    /**
     * @covers ::hasParameter
     */
    public function testHasExistingParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        
        self::assertTrue($contentType->hasParameter('foo'));
    }

    /**
     * @covers ::hasParameter
     */
    public function testDoesNotHaveNonExistingParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        
        self::assertFalse($contentType->hasParameter('bar'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCanGetParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        $parameter = new Parameter('foo', 'bar');
        
        self::assertEquals($parameter, $contentType->getParameter('foo'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCannotGetNonExistingParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        
        $this->expectException(OutOfBoundsException::class);
        
        $contentType->getParameter('bar');
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        
        $contentTypeSetParameter = new ContentType(new MediaType('text', 'html'));
        $contentTypeSetParameter->setParameter(new Parameter('foo', 'bar'));

        self::assertEquals($contentType, $contentTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetExistingParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'foo')));
        
        $contentTypeSetParameter = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        $contentTypeSetParameter->setParameter(new Parameter('foo', 'foo'));

        self::assertEquals($contentType, $contentTypeSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetMultipleParameters(): void
    {
        $contentType = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        ));
        
        $contentTypeSetParameter = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        $contentTypeSetParameter->setParameter(new Parameter('test', 'foo bar'), new Parameter('bar', 'foo'));

        self::assertEquals($contentType, $contentTypeSetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html'));
        
        $contentTypeUnsetParameter = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        $contentTypeUnsetParameter->unsetParameter('foo');

        self::assertEquals($contentType, $contentTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCannotUnsetNonExistingParameter(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('foo', 'bar')));
        
        $this->expectException(OutOfBoundsException::class);
        
        $contentType->unsetParameter('bar');
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParameters(): void
    {
        $contentType = new ContentType(new MediaType('text', 'html', new Parameter('test', 'foo bar')));
        
        $contentTypeUnsetParameter = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        ));
        $contentTypeUnsetParameter->unsetParameter('foo', 'bar');

        self::assertEquals($contentType, $contentTypeUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testNothingIsUnsetWhenUnsettingMultipleParametersWhereOneIsNonExisting(): void
    {
        $contentType = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        ));

        $contentTypeUnsetParameter = new ContentType(new MediaType(
            'text',
            'html',
            new Parameter('foo', 'bar'),
            new Parameter('test', 'foo bar'),
            new Parameter('bar', 'foo')
        ));
        try {
            $contentTypeUnsetParameter->unsetParameter('foo', 'qwerty', 'bar');
        } catch (OutOfBoundsException $exception) {
            // 'qwerty' is not found.
        }

        self::assertEquals($contentType, $contentTypeUnsetParameter);
    }
}
