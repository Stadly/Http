<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\EntityTag
 * @covers ::<protected>
 * @covers ::<private>
 */
final class EntityTagTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructEntityTag(): void
    {
        new EntityTag('foo');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructEmptyEntityTag(): void
    {
        new EntityTag('');
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructInvalidEntityTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new EntityTag('f o o');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructWeakEntityTag(): void
    {
        new EntityTag('foo', /*isWeak*/true);
        
        // Force generation of code coverage
        self::assertTrue(true);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEntityTagFromString(): void
    {
        $entityTag = new EntityTag('foo');
        $entityTagFromString = EntityTag::fromString('"foo"');
        
        self::assertEquals($entityTag, $entityTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructEmptyEntityTagFromString(): void
    {
        $entityTag = new EntityTag('');
        $entityTagFromString = EntityTag::fromString('""');
        
        self::assertEquals($entityTag, $entityTagFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructInvalidEntityTagFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        EntityTag::fromString('"f o o"');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructEntityTagFromStringMissingQuotes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        EntityTag::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructWeakEntityTagFromString(): void
    {
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        $entityTagFromString = EntityTag::fromString('W/"bar"');
        
        self::assertEquals($entityTag, $entityTagFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertEntityTagToString(): void
    {
        $entityTag = new EntityTag('foo');
        
        self::assertSame('"foo"', (string)$entityTag);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertEmptyEntityTagToString(): void
    {
        $entityTag = new EntityTag('');
        
        self::assertSame('""', (string)$entityTag);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertWeakEntityTagToString(): void
    {
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertSame('W/"bar"', (string)$entityTag);
    }

    /**
     * @covers ::isWeak
     */
    public function testStrongEntityTagIsNotWeak(): void
    {
        $entityTag = new EntityTag('foo');
        
        self::assertFalse($entityTag->isWeak());
    }

    /**
     * @covers ::isWeak
     */
    public function testWeakEntityTagIsWeak(): void
    {
        $entityTag = new EntityTag('bar', /*isWeak*/true);
        
        self::assertTrue($entityTag->isWeak());
    }

    /**
     * @covers ::setWeak
     */
    public function testCanSetWeak(): void
    {
        $entityTag = new EntityTag('bar', /*isWeak*/true);

        $entityTagSetWeak = new EntityTag('bar');
        $entityTagSetWeak->setWeak(true);
        
        self::assertEquals($entityTag, $entityTagSetWeak);
    }

    /**
     * @covers ::setWeak
     */
    public function testCanSetNotWeak(): void
    {
        $entityTag = new EntityTag('foo');

        $entityTagSetWeak = new EntityTag('foo', /*isWeak*/true);
        $entityTagSetWeak->setWeak(false);
        
        self::assertEquals($entityTag, $entityTagSetWeak);
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $entityTag = new EntityTag('foo');
        
        self::assertSame('foo', $entityTag->getValue());
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagComparesStronglyToStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('foo');
        
        self::assertTrue($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('foo', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('bar');
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('bar', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToDifferentStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('test');
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testStrongEntityTagDoesNotCompareStronglyToDifferentWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToDifferentStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('test');
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareStrongly
     */
    public function testWeakEntityTagDoesNotCompareStronglyToDifferentWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareStrongly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('foo');
        
        self::assertTrue($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagComparesWeaklyToWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('foo', /*isWeak*/true);
        
        self::assertTrue($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('bar');
        
        self::assertTrue($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagComparesWeaklyToWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('bar', /*isWeak*/true);
        
        self::assertTrue($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagDoesNotCompareWeaklyToDifferentStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('test');
        
        self::assertFalse($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testStrongEntityTagDoesNotCompareWeaklyToDifferentWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('foo');
        $entityTag2 = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesNotCompareWeaklyToDifferentStrongEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('test');
        
        self::assertFalse($entityTag1->compareWeakly($entityTag2));
    }

    /**
     * @covers ::compareWeakly
     */
    public function testWeakEntityTagDoesNotCompareWeaklyToDifferentWeakEntityTag(): void
    {
        $entityTag1 = new EntityTag('bar', /*isWeak*/true);
        $entityTag2 = new EntityTag('test', /*isWeak*/true);
        
        self::assertFalse($entityTag1->compareWeakly($entityTag2));
    }
}
