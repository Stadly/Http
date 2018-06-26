<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\EntityTag;

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
    public function testCanConstructIfNoneMatchWithoutEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        // Force generation of code coverage
        $ifNoneMatchConstruct = new IfNoneMatch();
        self::assertEquals($ifNoneMatch, $ifNoneMatchConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfNoneMatchWithSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        // Force generation of code coverage
        $ifNoneMatchConstruct = new IfNoneMatch(new EntityTag('foo'));
        self::assertEquals($ifNoneMatch, $ifNoneMatchConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfNoneMatchWithMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        // Force generation of code coverage
        $ifNoneMatchConstruct = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        self::assertEquals($ifNoneMatch, $ifNoneMatchConstruct);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithoutEntityTagsToString(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        self::assertSame('If-None-Match: *', (string)$ifNoneMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithSingleEntityTagToString(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        self::assertSame('If-None-Match: "foo"', (string)$ifNoneMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfNoneMatchWithMultipleEntityTagsToString(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertSame('If-None-Match: "foo", W/"bar", "entity-tag", ""', (string)$ifNoneMatch);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        self::assertSame('If-None-Match', $ifNoneMatch->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithoutEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        self::assertSame('*', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        self::assertSame('"foo"', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfNoneMatchWithMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertSame('"foo", W/"bar", "entity-tag", ""', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::isAny
     */
    public function testIfNoneMatchWithoutEntityTagsRepresentsAnyEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        self::assertTrue($ifNoneMatch->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testIfNoneMatchWithSingleEntityTagDoesNotRepresentAnyEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        self::assertFalse($ifNoneMatch->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testIfNoneMatchWithMultipleEntityTagsDoesNotRepresentAnyEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifNoneMatch->isAny());
    }

    /**
     * @covers ::add
     */
    public function testCanAddNothing(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        $ifNoneMatchAdd = new IfNoneMatch(new EntityTag('foo'));
        $ifNoneMatchAdd->add();

        self::assertEquals($ifNoneMatch, $ifNoneMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        
        $ifNoneMatchAdd = new IfNoneMatch(new EntityTag('foo'));
        $ifNoneMatchAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($ifNoneMatch, $ifNoneMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        $ifNoneMatchAdd = new IfNoneMatch(new EntityTag('foo'));
        $ifNoneMatchAdd->add(new EntityTag('bar', /*isWeak*/true), new EntityTag('entity-tag'), new EntityTag(''));

        self::assertEquals($ifNoneMatch, $ifNoneMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddExistingEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        
        $ifNoneMatchAdd = new IfNoneMatch(new EntityTag('foo'), new EntityTag('bar'));
        $ifNoneMatchAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($ifNoneMatch, $ifNoneMatchAdd);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNothing(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        $ifNoneMatchRemove = new IfNoneMatch(new EntityTag('foo'));
        $ifNoneMatchRemove->remove();

        self::assertEquals($ifNoneMatch, $ifNoneMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        $ifNoneMatchRemove = new IfNoneMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        $ifNoneMatchRemove->remove('bar');

        self::assertEquals($ifNoneMatch, $ifNoneMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        $ifNoneMatchRemove = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifNoneMatchRemove->remove('bar', 'entity-tag', '');

        self::assertEquals($ifNoneMatch, $ifNoneMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNonExistingEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch(new EntityTag('foo'));
        
        $ifNoneMatchRemove = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifNoneMatchRemove->remove('bar', 'entity-tag', 'qwerty', '');

        self::assertEquals($ifNoneMatch, $ifNoneMatchRemove);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfNoneMatchWithoutEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        $ifNoneMatchClear = new IfNoneMatch();
        $ifNoneMatchClear->clear();

        self::assertEquals($ifNoneMatch, $ifNoneMatchClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfNoneMatchWithSingleEntityTag(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        $ifNoneMatchClear = new IfNoneMatch(new EntityTag('foo'));
        $ifNoneMatchClear->clear();

        self::assertEquals($ifNoneMatch, $ifNoneMatchClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfNoneMatchWithMultipleEntityTags(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        $ifNoneMatchClear = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifNoneMatchClear->clear();

        self::assertEquals($ifNoneMatch, $ifNoneMatchClear);
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullComparesStronglyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        self::assertTrue($ifNoneMatch->compareStrongly(null));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagComparesStronglyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToStrongEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToStrongEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertFalse($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToWeakEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');
        
        self::assertFalse($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToWeakEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertFalse($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');
        
        self::assertFalse($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($ifNoneMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullDoesNotCompareStronglyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifNoneMatch->compareStrongly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullComparesWeaklyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        
        self::assertTrue($ifNoneMatch->compareWeakly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToEmptyIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch();
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToStrongEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesComparesWeaklyToStrongEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToWeakEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToWeakEntityTagInIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertTrue($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagDoesNotCompareWeaklyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');
        
        self::assertFalse($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesNotCompareWeaklyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($ifNoneMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullDoesNotCompareWeaklyToIfNoneMatch(): void
    {
        $ifNoneMatch = new IfNoneMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifNoneMatch->compareWeakly(null));
    }
}
