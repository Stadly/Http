<?php

declare(strict_types=1);

namespace Stadly\Http\Header;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Common\Header;
use Stadly\Http\Header\Common\ContentType;
use Stadly\Http\Header\Request\IfMatch;
use Stadly\Http\Header\Request\IfNoneMatch;
use Stadly\Http\Header\Response\ETag;
use Stadly\Http\Header\Value\EntityTag;
use Stadly\Http\Header\Value\EntityTagSet;
use Stadly\Http\Header\Value\MediaType;

/**
 * @coversDefaultClass \Stadly\Http\Header\Factory
 * @covers ::<protected>
 * @covers ::<private>
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromString(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = Factory::fromString('foo:bar');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderFromStringWithWhitespaceAroundName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::fromString("\t foo\t  :bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromStringWithWhitespaceAroundValue(): void
    {
        $header = new Header('foo', 'bar');
        $headerFromString = Factory::fromString("foo: \t bar\t  ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Factory::fromString(':bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromString(): void
    {
        $header = new Header('foo', '');
        $headerFromString = Factory::fromString('foo:');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromStringWithWhitespace(): void
    {
        $header = new Header('foo', '');
        $headerFromString = Factory::fromString("foo: \t\t ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromString(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = Factory::fromString('Content-Type: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromStringWithLowercaseName(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = Factory::fromString('content-type: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructContentTypeHeaderFromStringWithUppercaseName(): void
    {
        $contentType = new ContentType(new MediaType('foo', 'bar'));
        $contentTypeFromString = Factory::fromString('CONTENT-TYPE: foo/bar');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfMatchHeaderFromString(): void
    {
        $contentType = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $contentTypeFromString = Factory::fromString('If-Match: "foo", W/"bar"');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $ifMatchFromString = Factory::fromString('if-match: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $ifMatchFromString = Factory::fromString('IF-MATCH: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromString(): void
    {
        $contentType = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $contentTypeFromString = Factory::fromString('If-None-Match: "foo", W/"bar"');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $ifNoneMatchFromString = Factory::fromString('if-none-match: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*IsWeak*/true)));
        $ifNoneMatchFromString = Factory::fromString('IF-NONE-MATCH: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructETagHeaderFromString(): void
    {
        $contentType = new ETag(new EntityTag('foo'));
        $contentTypeFromString = Factory::fromString('ETag: "foo"');

        self::assertEquals($contentType, $contentTypeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructETagHeaderFromStringWithLowercaseName(): void
    {
        $eTag = new ETag(new EntityTag('foo'));
        $eTagFromString = Factory::fromString('etag: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructETagHeaderFromStringWithUppercaseName(): void
    {
        $eTag = new ETag(new EntityTag('foo'));
        $eTagFromString = Factory::fromString('ETAG: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }
}
