<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Stadly\Http\Utilities\Rfc7230
 * @covers ::<protected>
 * @covers ::<private>
 */
final class Rfc7230Test extends TestCase
{
    /**
     * @covers ::hashRule
     */
    public function testCannotHaveNegativeMin(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Rfc7230::hashRule('foobar', -1);
    }

    /**
     * @covers ::hashRule
     */
    public function testCannotHaveMaxSmallerThanMin(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Rfc7230::hashRule('foobar', 1, 0);
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroMatchesEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroMatchesEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(1, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroMatchesExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroMatchesExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 0) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 0, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 1) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 1, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, 2) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyListWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithTwoElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithThreeElmWithWhitespace(): void
    {
        $regEx = '{^' . Rfc7230::hashRule('foobar', 2, null) . '$}';

        self::assertSame(1, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }
}
