<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use InvalidArgumentException;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Stadly\Http\Header\Value\ContentDisposition\ExtendedParameter;
use Stadly\Http\Header\Value\ContentDisposition\RegularParameter;

/**
 * @coversDefaultClass \Stadly\Http\Header\Response\ContentDisposition
 * @covers ::<protected>
 * @covers ::<private>
 */
final class ContentDispositionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanConstructContentDisposition(): void
    {
        $contentDisposition = new ContentDisposition('foo');

        // Force generation of code coverage
        $contentDispositionConstruct = new ContentDisposition('foo');
        self::assertEquals($contentDisposition, $contentDispositionConstruct);
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructContentDispositionWithEmptyType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentDisposition('');
    }

    /**
     * @covers ::__construct
     */
    public function testCannotConstructContentDispositionWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentDisposition('f o o');
    }

    /**
     * @covers ::fromValue
     */
    public function testCannotConstructContentDispositionWithEmptyTypeFromValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ContentDisposition::fromValue('');
    }

    /**
     * @covers ::fromValue
     */
    public function testCanConstructContentDispositionFromValue(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', 'test.txt'),
            new ExtendedParameter('filename*', '€ rate.txt')
        );
        $contentDispositionValue = "attachment;filename=test.txt;filename*=UTF-8''%E2%82%AC%20rate.txt";
        $contentDispositionFromValue = ContentDisposition::fromValue($contentDispositionValue);

        self::assertEquals($contentDisposition, $contentDispositionFromValue);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentDispositionWithoutParametersToString(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        self::assertSame('Content-Disposition: attachment', (string)$contentDisposition);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentDispositionWithSingleParameterToString(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('filename', 'test.txt'));

        self::assertSame('Content-Disposition: attachment; filename=test.txt', (string)$contentDisposition);
    }

    /**
     * @covers ::__toString
     */
    public function testCanConvertContentDispositionWithMultipleParametersToString(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', 'test.txt'),
            new ExtendedParameter('filename*', '€ rate.txt')
        );

        self::assertSame(
            "Content-Disposition: attachment; filename=test.txt; filename*=UTF-8''%E2%82%AC%20rate.txt",
            (string)$contentDisposition
        );
    }

    /**
     * @covers ::isValid
     */
    public function testHeaderIsValid(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        self::assertTrue($contentDisposition->isValid()); // @phpstan-ignore-line
    }

    /**
     * @covers ::getName
     */
    public function testCanGetName(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        self::assertSame('Content-Disposition', $contentDisposition->getName());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithoutParameters(): void
    {
        $ifNoneMatch = new ContentDisposition('attachment');

        self::assertSame('attachment', $ifNoneMatch->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithSingleParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('filename', 'test.txt'));

        self::assertSame('attachment; filename=test.txt', $contentDisposition->getValue());
    }

    /**
     * @covers ::getValue
     */
    public function testCanGetValueForContentDispositionWithMultipleParameters(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', 'test.txt'),
            new ExtendedParameter('filename*', '€ rate.txt')
        );

        self::assertSame(
            "attachment; filename=test.txt; filename*=UTF-8''%E2%82%AC%20rate.txt",
            $contentDisposition->getValue()
        );
    }

    /**
     * @covers ::getType
     */
    public function testCanGetType(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        self::assertSame('attachment', $contentDisposition->getType());
    }

    /**
     * @covers ::setType
     */
    public function testCanSetType(): void
    {
        $contentDisposition = new ContentDisposition('inline');

        $contentDispositionSetType = new ContentDisposition('attachment');
        $contentDispositionSetType->setType('inline');

        self::assertEquals($contentDisposition, $contentDispositionSetType);
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetEmptyType(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        $this->expectException(InvalidArgumentException::class);

        $contentDisposition->setType('');
    }

    /**
     * @covers ::setType
     */
    public function testCannotSetInvalidType(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        $this->expectException(InvalidArgumentException::class);

        $contentDisposition->setType('f o o');
    }

    /**
     * @covers ::hasParameter
     */
    public function testHasExistingParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));

        self::assertTrue($contentDisposition->hasParameter('foo'));
    }

    /**
     * @covers ::hasParameter
     */
    public function testDoesNotHaveNonExistingParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));

        self::assertFalse($contentDisposition->hasParameter('bar'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCanGetParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));
        $parameter = new RegularParameter('foo', 'bar');

        self::assertEquals($parameter, $contentDisposition->getParameter('foo'));
    }

    /**
     * @covers ::getParameter
     */
    public function testCannotGetNonExistingParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));

        $this->expectException(OutOfBoundsException::class);

        $contentDisposition->getParameter('bar');
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));

        $contentDispositionSetParameter = new ContentDisposition('attachment');
        $contentDispositionSetParameter->setParameter(new RegularParameter('foo', 'bar'));

        self::assertEquals($contentDisposition, $contentDispositionSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetExistingParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'foo'));

        $contentDispositionSetParameter = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));
        $contentDispositionSetParameter->setParameter(new RegularParameter('foo', 'foo'));

        self::assertEquals($contentDisposition, $contentDispositionSetParameter);
    }

    /**
     * @covers ::setParameter
     */
    public function testCanSetMultipleParameters(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('foo', 'bar'),
            new RegularParameter('test', 'foo bar'),
            new RegularParameter('bar', 'foo')
        );

        $contentDispositionSetParameter = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));
        $contentDispositionSetParameter->setParameter(
            new RegularParameter('test', 'foo bar'),
            new RegularParameter('bar', 'foo')
        );

        self::assertEquals($contentDisposition, $contentDispositionSetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment');

        $contentDispositionUnsetParameter = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));
        $contentDispositionUnsetParameter->unsetParameter('foo');

        self::assertEquals($contentDisposition, $contentDispositionUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetNonExistingParameter(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));

        $contentDispositionUnsetParameter = new ContentDisposition('attachment', new RegularParameter('foo', 'bar'));
        $contentDispositionUnsetParameter->unsetParameter('bar');

        self::assertEquals($contentDisposition, $contentDispositionUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParameters(): void
    {
        $contentDisposition = new ContentDisposition('attachment', new RegularParameter('test', 'foo bar'));

        $contentDispositionUnsetParameter = new ContentDisposition(
            'attachment',
            new RegularParameter('foo', 'bar'),
            new RegularParameter('test', 'foo bar'),
            new RegularParameter('bar', 'foo')
        );
        $contentDispositionUnsetParameter->unsetParameter('foo', 'bar');

        self::assertEquals($contentDisposition, $contentDispositionUnsetParameter);
    }

    /**
     * @covers ::unsetParameter
     */
    public function testCanUnsetMultipleParametersWhereOneIsNonExisting(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('test', 'foo bar'),
        );

        $contentDispositionUnsetParameter = new ContentDisposition(
            'attachment',
            new RegularParameter('foo', 'bar'),
            new RegularParameter('test', 'foo bar'),
            new RegularParameter('bar', 'foo')
        );
        $contentDispositionUnsetParameter->unsetParameter('foo', 'qwerty', 'bar');

        self::assertEquals($contentDisposition, $contentDispositionUnsetParameter);
    }

    /**
     * @covers ::setFilename
     */
    public function testCanSetAsciiFilename(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', 'test.txt'),
        );

        $contentDispositionSetFilename = new ContentDisposition('attachment');
        $contentDispositionSetFilename->setFilename('test.txt');

        self::assertEquals($contentDisposition, $contentDispositionSetFilename);
    }

    /**
     * @covers ::setFilename
     */
    public function testCanSetUtf8Filename(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', '- rate.txt'),
            new ExtendedParameter('filename*', '€ rate.txt'),
        );

        $contentDispositionSetFilename = new ContentDisposition('attachment');
        $contentDispositionSetFilename->setFilename('€ rate.txt');

        self::assertEquals($contentDisposition, $contentDispositionSetFilename);
    }

    /**
     * @covers ::setFilename
     */
    public function testSetFilenameUnsetsFilenameParameters(): void
    {
        $contentDisposition = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', 'test.txt'),
        );

        $contentDispositionSetFilename = new ContentDisposition(
            'attachment',
            new RegularParameter('filename', '- rate.txt'),
            new ExtendedParameter('filename*', '€ rate.txt'),
        );
        $contentDispositionSetFilename->setFilename('test.txt');

        self::assertEquals($contentDisposition, $contentDispositionSetFilename);
    }
}
