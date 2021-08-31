<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Exception\InvalidHeader;
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
    public function testCannotConstructIfMatchWithEmptyEntityTagSetFromValue(): void
    {
        $this->expectException(InvalidHeader::class);

        IfMatch::fromValue('');
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
     * @covers ::fromValue
     */
    public function testCanConstructIfMatchWithoutEntityTagsFromValue(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());
        $ifMatchFromValue = IfMatch::fromValue('*');

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
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());

        self::assertTrue($ifMatch->isValid()); // @phpstan-ignore-line
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
     * @covers ::evaluate
     */
    public function testAnyHeaderEvaluatesToTrueWithNoEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());

        self::assertTrue($ifMatch->evaluate(null));
    }

    /**
     * @covers ::evaluate
     */
    public function testAnyHeaderEvaluatesToTrueWithStrongEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());
        $entityTag = new EntityTag('foo');

        self::assertTrue($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testAnyHeaderEvaluatesToTrueWithWeakEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet());
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertTrue($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderWithStrongEntityTagEvaluatesToTrueWithStrongEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('foo');

        self::assertTrue($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderWithStrongEntityTagEvaluatesToFalseWithWeakEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertFalse($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderWithWeakEntityTagEvaluatesToFalseWithStrongEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('bar');

        self::assertFalse($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderWithWeakEntityTagEvaluatesToFalseWithWeakEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('bar', /*isWeak*/true);

        self::assertFalse($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderEvaluatesToFalseWithMissingStrongEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('test');

        self::assertFalse($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderEvaluatesToFalseWithMissingWeakEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));
        $entityTag = new EntityTag('test', /*isWeak*/true);

        self::assertFalse($ifMatch->evaluate($entityTag));
    }

    /**
     * @covers ::evaluate
     */
    public function testHeaderEvaluatesToFalseWithNoEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        ));

        self::assertFalse($ifMatch->evaluate(null));
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
