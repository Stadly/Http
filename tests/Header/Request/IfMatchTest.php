<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\EntityTag\EntityTag;
use Stadly\Http\Header\Value\EntityTag\EntityTagSet;

/**
 * @coversDefaultClass \Stadly\Http\Header\Request\IfMatch
 * @covers ::<protected>
 * @covers ::<private>
 */
final class IfMatchTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructIfMatch(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo')));

        // Force generation of code coverage
        $ifMatchConstruct = new IfMatch(new EntityTagSet(new EntityTag('foo')));
        self::assertEquals($ifMatch, $ifMatchConstruct);
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructIfMatchFromValue(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo')));
        $ifMatchFromValue = IfMatch::fromValue('"foo"');

        self::assertEquals($ifMatch, $ifMatchFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithoutEntityTagsToString(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());

        self::assertSame('If-Match: *', (string)$ifMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithSingleEntityTagToString(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('If-Match: "foo"', (string)$ifMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithMultipleEntityTagsToString(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));

        self::assertSame('If-Match: "foo", W/"bar", "entity-tag", ""', (string)$ifMatch);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('If-Match', $ifMatch->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithoutEntityTags(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());

        self::assertSame('*', $ifMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithSingleEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(new EntityTag('foo')));

        self::assertSame('"foo"', $ifMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));

        self::assertSame('"foo", W/"bar", "entity-tag", ""', $ifMatch->getValue());
    }

    /**
     * @covers ::getEntityTagSet
     */
    public function testCanGetEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $ifMatch = new IfMatch($entityTagSet);

        self::assertSame($entityTagSet, $ifMatch->getEntityTagSet());
    }

    /**
     * @covers ::setEntityTagSet
     */
    public function testCanSetEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $ifMatch = new IfMatch($entityTagSet);

        $ifMatchSetType = new IfMatch(new EntityTagSet(new EntityTag('bar', /*isWeak*/true)));
        $ifMatchSetType->setEntityTagSet($entityTagSet);

        self::assertEquals($ifMatch, $ifMatchSetType);
    }
}
