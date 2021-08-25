<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Header\Value\CacheControl\FieldListDirective
 * @covers ::<protected>
 * @covers ::<private>
 */
final class FieldListDirectiveTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructDirective(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        // Force generation of code coverage
        $directiveConstruct = new FieldListDirective('foo', 'bar', '5', 'baz');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('', 'bar', '5', 'baz');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('f o o', 'bar', '5', 'baz');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('max-age', 'bar', '5', 'baz');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithNameReservedForValueless(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('must-revalidate', 'bar', '5', 'baz');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithEmptyFieldName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('foo', '');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructDirectiveWithInvalidFieldName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FieldListDirective('foo', 'f o o');
    }

    /**
     * @covers ::__construct
     */
    public function testCanConstructDirectiveWithEmptyFieldList(): void
    {
        $directive = new FieldListDirective('foo');

        // Force generation of code coverage
        $directiveConstruct = new FieldListDirective('foo');
        self::assertEquals($directive, $directiveConstruct);
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveFromString(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveFromString = FieldListDirective::fromString('foo="bar, 5, baz"');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        FieldListDirective::fromString('="bar, 5, baz"');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvalidNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        FieldListDirective::fromString('f o o="bar, 5, baz"');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithInvlidFieldNameFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        FieldListDirective::fromString('foo="f o o"');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithUnquotedValueFromString(): void
    {
        $directive = new FieldListDirective('foo', 'bar');
        $directiveFromString = FieldListDirective::fromString('foo=bar');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithoutValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        FieldListDirective::fromString('foo');
    }

    /**
     * @covers ::fromString
     */
    public function testCannotConstructDirectiveWithEmptyValueFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        FieldListDirective::fromString('foo=');
    }

    /**
     * @covers ::fromString
     */
    public function testCanConstructDirectiveWithEmptyQuotedValueFromString(): void
    {
        $directive = new FieldListDirective('foo');
        $directiveFromString = FieldListDirective::fromString('foo=""');

        self::assertEquals($directive, $directiveFromString);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertDirectiveToString(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        self::assertSame('foo="bar, 5, baz"', (string)$directive);
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        self::assertSame('foo', $directive->getName());
    }

    /**
     * @covers ::setName
     */
    public function testCanSetName(): void
    {
        $directive = new FieldListDirective('bar', 'bar', '5', 'baz');

        $directiveSetName = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveSetName->setName('bar');

        self::assertEquals($directive, $directiveSetName);
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetEmptyName(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetInvalidName(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('f o o');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForInteger(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('max-age');
    }

    /**
     * @covers ::setName
     */
    public function testCannotSetNameReservedForValueless(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $this->expectException(InvalidArgumentException::class);

        $directive->setName('must-revalidate');
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValue(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        self::assertSame('bar, 5, baz', $directive->getValue());
    }

    /**
     * @covers ::add
     */
    public function testCanAddNothing(): void
    {
        $directive = new FieldListDirective('foo', 'bar');

        $directiveAdd = new FieldListDirective('foo', 'bar');
        $directiveAdd->add();

        self::assertEquals($directive, $directiveAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddSingleFieldName(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5');

        $directiveAdd = new FieldListDirective('foo', 'bar');
        $directiveAdd->add('5');

        self::assertEquals($directive, $directiveAdd);
    }

    /**
     * @covers ::add
     */
    public function testCanAddMultipleFieldNames(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $directiveAdd = new FieldListDirective('foo', 'bar');
        $directiveAdd->add('5', 'baz');

        self::assertEquals($directive, $directiveAdd);
    }

    /**
     * @covers ::add
     */
    public function testAddingExistingFieldNameOverwrites(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $directiveAdd = new FieldListDirective('foo', 'bar', '5');
        $directiveAdd->add('bar', 'baz');

        self::assertEquals($directive, $directiveAdd);
    }

    /**
     * @covers ::add
     */
    public function testCannotAddEmptyFieldName(): void
    {
        $directive = new FieldListDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->add('');
    }

    /**
     * @covers ::add
     */
    public function testCannotAddInvalidFieldName(): void
    {
        $directive = new FieldListDirective('foo');

        $this->expectException(InvalidArgumentException::class);

        $directive->add('f o o');
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNothing(): void
    {
        $directive = new FieldListDirective('foo', 'bar', '5', 'baz');

        $directiveRemove = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveRemove->remove();

        self::assertEquals($directive, $directiveRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveSingleFieldName(): void
    {
        $directive = new FieldListDirective('foo', '5', 'baz');

        $directiveRemove = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveRemove->remove('bar');

        self::assertEquals($directive, $directiveRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveMultipleFieldNames(): void
    {
        $directive = new FieldListDirective('foo', 'bar');

        $directiveRemove = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveRemove->remove('5', 'baz');

        self::assertEquals($directive, $directiveRemove);
    }

    /**
     * @covers ::remove
     */
    public function testCanRemoveNonExistingFieldName(): void
    {
        $directive = new FieldListDirective('foo', '5');

        $directiveRemove = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveRemove->remove('bar', 'baz', 'test');

        self::assertEquals($directive, $directiveRemove);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearFieldListDirectiveWithoutFieldNames(): void
    {
        $directive = new FieldListDirective('foo');

        $directiveClear = new FieldListDirective('foo');
        $directiveClear->clear();

        self::assertEquals($directive, $directiveClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearFieldListDirectiveWithSingleFieldName(): void
    {
        $directive = new FieldListDirective('foo');

        $directiveClear = new FieldListDirective('foo', 'bar');
        $directiveClear->clear();

        self::assertEquals($directive, $directiveClear);
    }

    /**
     * @covers ::clear
     */
    public function testCanClearFieldListDirectiveWithMultipleFieldNames(): void
    {
        $directive = new FieldListDirective('foo');

        $directiveClear = new FieldListDirective('foo', 'bar', '5', 'baz');
        $directiveClear->clear();

        self::assertEquals($directive, $directiveClear);
    }

    /**
     * @covers ::getIterator
     */
    public function testCanGetIteratorForFieldListDirectiveWithoutFieldNames(): void
    {
        $fieldNames = [];
        $directive = new FieldListDirective('foo', ...$fieldNames);

        $fieldNamesGetIterator = [];
        foreach ($directive as $entityTag) {
            $fieldNamesGetIterator[] = $entityTag;
        }

        self::assertSame($fieldNames, $fieldNamesGetIterator);
    }

    /**
     * @covers ::getIterator
     */
    public function testCanGetIteratorForFieldListDirectiveWithSingleFieldName(): void
    {
        $fieldNames = ['bar'];
        $directive = new FieldListDirective('foo', ...$fieldNames);

        $fieldNamesGetIterator = [];
        foreach ($directive as $entityTag) {
            $fieldNamesGetIterator[] = $entityTag;
        }

        self::assertSame($fieldNames, $fieldNamesGetIterator);
    }

    /**
     * @covers ::getIterator
     */
    public function testCanGetIteratorForFieldListDirectiveWithMultipleFieldNames(): void
    {
        $fieldNames = ['foo', 'bar', '5', 'baz'];
        $directive = new FieldListDirective('foo', ...$fieldNames);

        $fieldNamesGetIterator = [];
        foreach ($directive as $entityTag) {
            $fieldNamesGetIterator[] = $entityTag;
        }

        self::assertSame($fieldNames, $fieldNamesGetIterator);
    }
}
