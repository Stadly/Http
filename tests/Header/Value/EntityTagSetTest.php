<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\EntityTagSet
 * @covers ::<protected>
 * @covers ::<private>
 */
final class EntityTagSetTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructEntityTagSetWithoutEntityTags(): void
    {
        $entityTagSet = new EntityTagSet();

        // Force generation of code coverage
        $entityTagSetConstruct = new EntityTagSet();
        self::assertEquals($entityTagSet, $entityTagSetConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructEntityTagSetWithSingleEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        // Force generation of code coverage
        $entityTagSetConstruct = new EntityTagSet(new EntityTag('foo'));
        self::assertEquals($entityTagSet, $entityTagSetConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructEntityTagSetWithMultipleEntityTags(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        // Force generation of code coverage
        $entityTagSetConstruct = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        self::assertEquals($entityTagSet, $entityTagSetConstruct);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagSetWithoutEntityTagsFromString(): void
    {
        $entityTagSet = new EntityTagSet();
        $entityTagSetFromString = EntityTagSet::fromString('*');

        self::assertEquals($entityTagSet, $entityTagSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagSetWithSingleEntityTagFromString(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetFromString = EntityTagSet::fromString('"foo"');

        self::assertEquals($entityTagSet, $entityTagSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagSetWithSingleEntityTagFromStringWithWhitespace(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetFromString = EntityTagSet::fromString(",\t,  ,\"foo\",,");

        self::assertEquals($entityTagSet, $entityTagSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagSetWithMultipleEntityTagsFromString(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTagSetFromString = EntityTagSet::fromString('"foo",W/"bar","entity-tag",""');

        self::assertEquals($entityTagSet, $entityTagSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagSetWithMultipleEntityTagsFromStringWithWhitespace(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTagSetFromString = EntityTagSet::fromString("\"foo\",\t  W/\"bar\",,,\"entity-tag\"   , \t, \"\",,");

        self::assertEquals($entityTagSet, $entityTagSetFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructEntityTagSetWithInvalidEntityTagFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EntityTagSet::fromString('"f o o"');
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertEntityTagSetWithoutEntityTagsToString(): void
    {
        $entityTagSet = new EntityTagSet();

        self::assertSame('*', (string)$entityTagSet);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertEntityTagSetWithSingleEntityTagToString(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        self::assertSame('"foo"', (string)$entityTagSet);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertEntityTagSetWithMultipleEntityTagsToString(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        self::assertSame('"foo", W/"bar", "entity-tag", ""', (string)$entityTagSet);
    }

    /**
     * @covers ::isAny
     */
    public function testEntityTagSetWithoutEntityTagsRepresentsAnyEntityTag(): void
    {
        $entityTagSet = new EntityTagSet();

        self::assertTrue($entityTagSet->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testEntityTagSetWithSingleEntityTagDoesNotRepresentAnyEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        self::assertFalse($entityTagSet->isAny());
    }

    /**
     * @covers ::isAny
     */
    public function testEntityTagSetWithMultipleEntityTagsDoesNotRepresentAnyEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        self::assertFalse($entityTagSet->isAny());
    }

    /**
     * @covers ::add
     */
    public function testCanAddNothing(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        $entityTagSetAdd = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetAdd->add();

        self::assertEquals($entityTagSet, $entityTagSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddSingleEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));

        $entityTagSetAdd = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($entityTagSet, $entityTagSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddMultipleEntityTags(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        $entityTagSetAdd = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetAdd->add(new EntityTag('bar', /*isWeak*/true), new EntityTag('entity-tag'), new EntityTag(''));

        self::assertEquals($entityTagSet, $entityTagSetAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddExistingEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));

        $entityTagSetAdd = new EntityTagSet(new EntityTag('foo'), new EntityTag('bar'));
        $entityTagSetAdd->add(new EntityTag('bar', /*isWeak*/true));

        self::assertEquals($entityTagSet, $entityTagSetAdd);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNothing(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        $entityTagSetRemove = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetRemove->remove();

        self::assertEquals($entityTagSet, $entityTagSetRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveSingleEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        $entityTagSetRemove = new EntityTagSet(new EntityTag('foo'), new EntityTag('bar', /*isWeak*/true));
        $entityTagSetRemove->remove('bar');

        self::assertEquals($entityTagSet, $entityTagSetRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveMultipleEntityTags(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        $entityTagSetRemove = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTagSetRemove->remove('bar', 'entity-tag', '');

        self::assertEquals($entityTagSet, $entityTagSetRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNonExistingEntityTag(): void
    {
        $entityTagSet = new EntityTagSet(new EntityTag('foo'));

        $entityTagSetRemove = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTagSetRemove->remove('bar', 'entity-tag', 'qwerty', '');

        self::assertEquals($entityTagSet, $entityTagSetRemove);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearEntityTagSetWithoutEntityTags(): void
    {
        $entityTagSet = new EntityTagSet();

        $entityTagSetClear = new EntityTagSet();
        $entityTagSetClear->clear();

        self::assertEquals($entityTagSet, $entityTagSetClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearEntityTagSetWithSingleEntityTag(): void
    {
        $entityTagSet = new EntityTagSet();

        $entityTagSetClear = new EntityTagSet(new EntityTag('foo'));
        $entityTagSetClear->clear();

        self::assertEquals($entityTagSet, $entityTagSetClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearEntityTagSetWithMultipleEntityTags(): void
    {
        $entityTagSet = new EntityTagSet();

        $entityTagSetClear = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTagSetClear->clear();

        self::assertEquals($entityTagSet, $entityTagSetClear);
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullComparesStronglyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();

        self::assertTrue($entityTagSet->compareStrongly(null));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();
        $entityTag = new EntityTag('foo');

        self::assertTrue($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagComparesStronglyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertTrue($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToStrongEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');

        self::assertTrue($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToStrongEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertFalse($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToWeakEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');

        self::assertFalse($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToWeakEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);

        self::assertFalse($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');

        self::assertFalse($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);

        self::assertFalse($entityTagSet->compareStrongly($entityTag));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testNullDoesNotCompareStronglyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        self::assertFalse($entityTagSet->compareStrongly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullComparesWeaklyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();

        self::assertTrue($entityTagSet->compareWeakly(null));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();
        $entityTag = new EntityTag('foo');

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToEmptyEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet();
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToStrongEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo');

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesComparesWeaklyToStrongEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('foo', /*isWeak*/true);

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToWeakEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar');

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToWeakEntityTagInEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('bar', /*isWeak*/true);

        self::assertTrue($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagDoesNotCompareWeaklyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test');

        self::assertFalse($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesNotCompareWeaklyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );
        $entityTag = new EntityTag('test', /*isWeak*/true);

        self::assertFalse($entityTagSet->compareWeakly($entityTag));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testNullDoesNotCompareWeaklyToEntityTagSet(): void
    {
        $entityTagSet = new EntityTagSet(
            new EntityTag('foo'),
            new EntityTag('bar', /*isWeak*/true),
            new EntityTag('entity-tag'),
            new EntityTag('')
        );

        self::assertFalse($entityTagSet->compareWeakly(null));
    }
}
