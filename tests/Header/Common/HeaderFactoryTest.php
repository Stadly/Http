<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\MediaType;

/**
 * @coversDefaultClass \Stadly\Http\Header\Common\HeaderFactory
 * @covers ::<protected>
 * @covers ::<private>
 */
final class HeaderFactoryTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromString(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = HeaderFactory::fromString('foo:bar');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderFromStringWithWhitespaceAroundName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        HeaderFactory::fromString("\t foo\t  :bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromStringWithWhitespaceAroundValue(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = HeaderFactory::fromString("foo: \t bar\t  ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        HeaderFactory::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        HeaderFactory::fromString(':bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromString(): void
    {
        $header = new Header('foo', '');
        $headerFromString = HeaderFactory::fromString('foo:');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromStringWithWhitespace(): void
    {
        $header = new Header('foo', '');
        $headerFromString = HeaderFactory::fromString("foo: \t\t ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromString(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = HeaderFactory::fromString('Content-Type: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromStringWithLowercaseName(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = HeaderFactory::fromString('content-type: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromStringWithUppercaseName(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = HeaderFactory::fromString('CONTENT-TYPE: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfMatchHeaderFromString(): void
    {
        $ifMatch = new Header('If-Match', '"foo", W/"bar"');
        $ifMatchFromString = HeaderFactory::fromString('If-Match: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifMatch = new Header('if-match', '"foo", W/"bar"');
        $ifMatchFromString = HeaderFactory::fromString('if-match: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifMatch = new Header('IF-MATCH', '"foo", W/"bar"');
        $ifMatchFromString = HeaderFactory::fromString('IF-MATCH: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfNoneMatchHeaderFromString(): void
    {
        $ifNoneMatch = new Header('If-None-Match', '"foo", W/"bar"');
        $ifNoneMatchFromString = HeaderFactory::fromString('If-None-Match: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfNoneMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifNoneMatch = new Header('if-none-match', '"foo", W/"bar"');
        $ifNoneMatchFromString = HeaderFactory::fromString('if-none-match: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructIfNoneMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifNoneMatch = new Header('IF-NONE-MATCH', '"foo", W/"bar"');
        $ifNoneMatchFromString = HeaderFactory::fromString('IF-NONE-MATCH: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromString(): void
    {
        $eTag = new Header('ETag', '"foo"');
        $eTagFromString = HeaderFactory::fromString('ETag: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromStringWithLowercaseName(): void
    {
        $eTag = new Header('etag', '"foo"');
        $eTagFromString = HeaderFactory::fromString('etag: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromStringWithUppercaseName(): void
    {
        $eTag = new Header('ETAG', '"foo"');
        $eTagFromString = HeaderFactory::fromString('ETAG: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }
}
