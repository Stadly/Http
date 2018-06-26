<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\EntityTag;

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
    public function testCanConstructIfMatchWithoutEntityTags(): void
    {
        $ifMatch = new IfMatch();
        
        // Force generation of code coverage
        $ifMatchConstruct = new IfMatch();
        self::assertEquals($ifMatch, $ifMatchConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfMatchWithSingleEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        // Force generation of code coverage
        $ifMatchConstruct = new IfMatch(new EntityTag('foo'));
        self::assertEquals($ifMatch, $ifMatchConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructIfMatchWithMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        // Force generation of code coverage
        $ifMatchConstruct = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        self::assertEquals($ifMatch, $ifMatchConstruct);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithoutEntityTagsToString(): void
    {
        $ifMatch = new IfMatch();
        
        self::assertSame('If-Match: *', (string)$ifMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithSingleEntityTagToString(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        self::assertSame('If-Match: "foo"', (string)$ifMatch);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertIfMatchWithMultipleEntityTagsToString(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertSame('If-Match: "foo", W/"bar", "entity-tag", ""', (string)$ifMatch);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        self::assertSame('If-Match', $ifMatch->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithoutEntityTags(): void
    {
        $ifMatch = new IfMatch();
        
        self::assertSame('*', $ifMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithSingleEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        self::assertSame('"foo"', $ifMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForIfMatchWithMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertSame('"foo", W/"bar", "entity-tag", ""', $ifMatch->getValue());
    }

    /**
     * @covers ::isAny
     */
    public function testIfMatchWithoutEntityTagsRepresentsAnyEntityTag(): void
    {
        $ifMatch = new IfMatch();
        
        self::assertTrue($ifMatch->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testIfMatchWithSingleEntityTagDoesNotRepresentAnyEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        self::assertFalse($ifMatch->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testIfMatchWithMultipleEntityTagsDoesNotRepresentAnyEntityTag(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifMatch->isAny());
    }

    /**
     * @covers ::add
     */
    public function testCanAddNothing(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        $ifMatchAdd = new IfMatch(new EntityTag('foo'));
        $ifMatchAdd->add();

        self::assertEquals($ifMatch, $ifMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddSingleEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        
        $ifMatchAdd = new IfMatch(new EntityTag('foo'));
        $ifMatchAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($ifMatch, $ifMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        $ifMatchAdd = new IfMatch(new EntityTag('foo'));
        $ifMatchAdd->add(new EntityTag('bar', /*isWeak*/true), new EntityTag('entity-tag'), new EntityTag(''));

        self::assertEquals($ifMatch, $ifMatchAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddExistingEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        
        $ifMatchAdd = new IfMatch(new EntityTag('foo'), new EntityTag('bar'));
        $ifMatchAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($ifMatch, $ifMatchAdd);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNothing(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        $ifMatchRemove = new IfMatch(new EntityTag('foo'));
        $ifMatchRemove->remove();

        self::assertEquals($ifMatch, $ifMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveSingleEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        $ifMatchRemove = new IfMatch(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        $ifMatchRemove->remove('bar');

        self::assertEquals($ifMatch, $ifMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        $ifMatchRemove = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifMatchRemove->remove('bar', 'entity-tag', '');

        self::assertEquals($ifMatch, $ifMatchRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNonExistingEntityTag(): void
    {
        $ifMatch = new IfMatch(new EntityTag('foo'));
        
        $ifMatchRemove = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifMatchRemove->remove('bar', 'entity-tag', 'qwerty', '');

        self::assertEquals($ifMatch, $ifMatchRemove);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfMatchWithoutEntityTags(): void
    {
        $ifMatch = new IfMatch();
        
        $ifMatchClear = new IfMatch();
        $ifMatchClear->clear();

        self::assertEquals($ifMatch, $ifMatchClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfMatchWithSingleEntityTag(): void
    {
        $ifMatch = new IfMatch();
        
        $ifMatchClear = new IfMatch(new EntityTag('foo'));
        $ifMatchClear->clear();

        self::assertEquals($ifMatch, $ifMatchClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearIfMatchWithMultipleEntityTags(): void
    {
        $ifMatch = new IfMatch();
        
        $ifMatchClear = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $ifMatchClear->clear();

        self::assertEquals($ifMatch, $ifMatchClear);
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullComparesStronglyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        
        self::assertTrue($ifMatch->compareStrongly(null));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagComparesStronglyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToStrongEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToStrongEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertFalse($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToWeakEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');
        
        self::assertFalse($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToWeakEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertFalse($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');
        
        self::assertFalse($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($ifMatch->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullDoesNotCompareStronglyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifMatch->compareStrongly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullComparesWeaklyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        
        self::assertTrue($ifMatch->compareWeakly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToEmptyIfMatch(): void
    {
        $ifMatch = new IfMatch();
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToStrongEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesComparesWeaklyToStrongEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToWeakEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToWeakEntityTagInIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertTrue($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagDoesNotCompareWeaklyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');
        
        self::assertFalse($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesNotCompareWeaklyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($ifMatch->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullDoesNotCompareWeaklyToIfMatch(): void
    {
        $ifMatch = new IfMatch(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        
        self::assertFalse($ifMatch->compareWeakly(null));
    }
}
