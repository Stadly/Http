<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\EntityTag\EntityTag;
use Stadly\Http\Header\Value\EntityTag\EntityTagSet;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\IfNoneMatch
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IfNoneMatchTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));

        // Force generation of code coverage
        $ifNoneMatchConstruct = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));
        self::assertEquals($ifNoneMatch, $ifNoneMatchConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfNoneMatchFromValue(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));
        $ifNoneMatchFromValue = IfNoneMatch::fromValue('"foo"');

        self::assertEquals($ifNoneMatch, $ifNoneMatchFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithoutEntityTagsToString(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet());

        self::assertSame('If-None-Match: *', (string)$ifNoneMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithSingleEntityTagToString(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('If-None-Match: "foo"', (string)$ifNoneMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithMultipleEntityTagsToString(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));

        self::assertSame('If-None-Match: "foo", W/"bar", "entity-tag", ""', (string)$ifNoneMatch);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('If-None-Match', $ifNoneMatch->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithoutEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet());

        self::assertSame('*', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('"foo"', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));

        self::assertSame('"foo", W/"bar", "entity-tag", ""', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getEntityTagSet
     */
    public function testCanGetEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $ifNoneMatch = new IfNoneMatch($entityTagSet);

        self::assertSame($entityTagSet, $ifNoneMatch->getEntityTagSet());
    }

    /**
     * @covers ::setEntityTagSet
     */
    public function testCanSetEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $ifNoneMatch = new IfNoneMatch($entityTagSet);

        $ifNoneMatchSetType = new IfNoneMatch(new EntityTagSet(new EntityTag('bar', /*isWeak*/true)));
        $ifNoneMatchSetType->setEntityTagSet($entityTagSet);

        self::assertEquals($ifNoneMatch, $ifNoneMatchSetType);
    }
}
