<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\EntityTag\EntityTag;

/**
 * @coversDefaultClass \Stadly\Http\Header\Response\ETag
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ETagTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructETag(): void
    {
        $eTag = new ETag(new EntityTag('foo'));

        // Force generation of code coverage
        $eTagConstruct = new ETag(new EntityTag('foo'));
        self::assertEquals($eTag, $eTagConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructETagFromValue(): void
    {
        $eTag = new ETag(new EntityTag('bar'));
        $eTagFromValue = ETag::fromValue('"bar"');

        self::assertEquals($eTag, $eTagFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertETagToString(): void
    {
        $eTag = new ETag(new EntityTag('foo'));

        self::assertSame('ETag: "foo"', (string)$eTag);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertWeakETagToString(): void
    {
        $eTag = new ETag(new EntityTag('foo', /*isWeak*/true));

        self::assertSame('ETag: W/"foo"', (string)$eTag);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $eTag = new ETag(new EntityTag('foo'));

        self::assertSame('ETag', $eTag->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForETag(): void
    {
        $eTag = new ETag(new EntityTag('foo'));

        self::assertSame('"foo"', $eTag->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForWeakETag(): void
    {
        $eTag = new ETag(new EntityTag('foo', /*isWeak*/true));

        self::assertSame('W/"foo"', $eTag->getValue());
    }

    /**
     * @covers ::getEntityTag
     */
    public function testCanGetEntityTag(): void
    {
        $entityTag = new EntityTag('foo');
        $eTag = new ETag($entityTag);

        self::assertSame($entityTag, $eTag->getEntityTag());
    }

    /**
     * @covers ::setEntityTag
     */
    public function testCanSetEntityTag(): void
    {
        $entityTag = new EntityTag('bar');
        $eTag = new ETag($entityTag);

        $eTagSetType = new ETag(new EntityTag('foo'));
        $eTagSetType->setEntityTag($entityTag);

        self::assertEquals($eTag, $eTagSetType);
    }
}
