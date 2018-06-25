<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

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
     * @covers ::getMediaType
     */
    public function testCanGetMediaType(): void
    {
        $mediaType = new MediaType('text', 'html');
        $contentType = new ContentType($mediaType);
        
        self::assertSame($mediaType, $contentType->getMediaType());
    }

    /**
     * @covers ::setMediaType
     */
    public function testCanSetMediaType(): void
    {
        $mediaType = new MediaType('multipart', 'html');
        $contentType = new ContentType($mediaType);
        
        $contentTypeSetType = new ContentType(new MediaType('text', 'html'));
        $contentTypeSetType->setMediaType($mediaType);

        self::assertEquals($contentType, $contentTypeSetType);
    }
}
