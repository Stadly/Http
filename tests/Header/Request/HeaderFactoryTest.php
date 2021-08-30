<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Common\ArbitraryHeader;
use Stadly\Http\Header\Common\ContentType;
use Stadly\Http\Header\Value\EntityTag\EntityTag;
use Stadly\Http\Header\Value\EntityTag\EntityTagSet;
use Stadly\Http\Header\Value\MediaType\MediaType;
use Stadly\Http\Header\Value\Range\ByteRange;
use Stadly\Http\Header\Value\Range\ByteRangeSet;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\HeaderFactory
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
        $header = new ArbitraryHeader('foo', 'bar');
        $headerFromString = HeaderFactory::fromString('foo:bar');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderFromStringWithWhitespaceAroundName(): void
    {
        $this->expectException(InvalidHeader::class);

        HeaderFactory::fromString("\t foo\t  :bar");
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderFromStringWithWhitespaceAroundValue(): void
    {
        $header = new ArbitraryHeader('foo', 'bar');
        $headerFromString = HeaderFactory::fromString("foo: \t bar\t  ");

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithoutValueFromString(): void
    {
        $this->expectException(InvalidHeader::class);

        HeaderFactory::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructHeaderWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidHeader::class);

        HeaderFactory::fromString(':bar');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromString(): void
    {
        $header = new ArbitraryHeader('foo', '');
        $headerFromString = HeaderFactory::fromString('foo:');

        self::assertEquals($header, $headerFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructHeaderWithEmptyValueFromStringWithWhitespace(): void
    {
        $header = new ArbitraryHeader('foo', '');
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
    public function testCanConstructIfMatchHeaderFromString(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifMatchFromString = HeaderFactory::fromString('If-Match: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifMatchFromString = HeaderFactory::fromString('if-match: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifMatchFromString = HeaderFactory::fromString('IF-MATCH: "foo", W/"bar"');

        self::assertEquals($ifMatch, $ifMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromString(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifNoneMatchFromString = HeaderFactory::fromString('If-None-Match: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromStringWithLowercaseName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifNoneMatchFromString = HeaderFactory::fromString('if-none-match: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructIfNoneMatchHeaderFromStringWithUppercaseName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true)));
        $ifNoneMatchFromString = HeaderFactory::fromString('IF-NONE-MATCH: "foo", W/"bar"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromString(): void
    {
        $eTag = new ArbitraryHeader('ETag', '"foo"');
        $eTagFromString = HeaderFactory::fromString('ETag: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromStringWithLowercaseName(): void
    {
        $eTag = new ArbitraryHeader('etag', '"foo"');
        $eTagFromString = HeaderFactory::fromString('etag: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructETagHeaderFromStringWithUppercaseName(): void
    {
        $eTag = new ArbitraryHeader('ETAG', '"foo"');
        $eTagFromString = HeaderFactory::fromString('ETAG: "foo"');

        self::assertEquals($eTag, $eTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeHeaderFromString(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));
        $rangeFromString = HeaderFactory::fromString('Range: bytes=10-100');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeHeaderFromStringWithLowercaseName(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));
        $rangeFromString = HeaderFactory::fromString('range: bytes=10-100');

        self::assertEquals($range, $rangeFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructRangeHeaderFromStringWithUppercaseName(): void
    {
        $range = new Range(new ByteRangeSet(new ByteRange(10, 100)));
        $rangeFromString = HeaderFactory::fromString('RANGE: bytes=10-100');

        self::assertEquals($range, $rangeFromString);
    }
}
