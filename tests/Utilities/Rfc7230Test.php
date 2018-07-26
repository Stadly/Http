<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

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
    public function testHashRuleFromZeroToZeroMatchesEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroMatchesExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToZeroDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 0).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToOneDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToTwoDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromZeroToUnboundedDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 0, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToOneDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 1).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToTwoDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromOneToUnboundedDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 1, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToTwoDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, 2).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ''));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchEmptyListWithWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " \t"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyList(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyListWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyListWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedEmptyListWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  , \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, 'foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithOneElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t  ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithTwoElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(1, preg_match($regEx, ",,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithTwoElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithTwoElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ",,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithTwoElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " ,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(1, preg_match($regEx, 'foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, ' foobar, foobar, foobar'));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar, foobar, foobar\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedMatchesExtendedListWithThreeElm(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(1, preg_match($regEx, "foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithThreeElmWithOpeningWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,"));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithThreeElmWithEndingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, "foobar,,  foobar, \t foobar ,\t "));
    }

    /**
     * @covers ::hashRule
     */
    public function testHashRuleFromTwoToUnboundedDoesNotMatchExtendedListWithThreeElmWithSurroundingWhitespace(): void
    {
        $regEx = '{^'.Rfc7230::hashRule('foobar', 2, null).'$}';
        
        self::assertSame(0, preg_match($regEx, " foobar,,  foobar, \t foobar ,\t "));
    }
}
