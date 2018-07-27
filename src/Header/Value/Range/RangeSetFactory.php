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
        $regEx = '{^'.Rfc7233::OTHER_RANGES_SPECIFIER_CAPTURE.'$}';
        if (utf8_decode($rangeSet) !== $rangeSet || 1 !== preg_match($regEx, $rangeSet, $matches)) {
            throw new InvalidArgumentException("Invalid set of ranges: $rangeSet");
        }

        switch (strtolower($matches['OTHER_RANGE_UNIT'])) {
            case 'bytes':
                return ByteRangeSet::fromString($rangeSet);
            default:
                return OtherRangeSet::fromString($rangeSet);
        }
    }
}
