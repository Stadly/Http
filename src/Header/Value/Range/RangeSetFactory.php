<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7233;

/**
 * Class for generating range sets.
 */
final class RangeSetFactory
{
    /**
     * Construct range set from string.
     *
     * @param string $rangeSet Range set string.
     * @return RangeSetInterface Range set generated based on the string.
     */
    public static function fromString(string $rangeSet): RangeSetInterface
    {
        if (utf8_decode($rangeSet) === $rangeSet) {
            if (1 === preg_match('{^'.Rfc7233::BYTE_RANGES_SPECIFIER.'$}', $rangeSet)) {
                return ByteRangeSet::fromString($rangeSet);
            }

            if (1 === preg_match('{^'.Rfc7233::OTHER_RANGES_SPECIFIER.'$}', $rangeSet)) {
                return OtherRangeSet::fromString($rangeSet);
            }
        }

        throw new InvalidArgumentException("Invalid set of ranges: $rangeSet");
    }
}
