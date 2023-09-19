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
     * @return RangeSet Range set generated based on the string.
     */
    public static function fromString(string $rangeSet): RangeSet
    {
        $plainRangeSet = mb_convert_encoding($rangeSet, 'ISO-8859-1', 'UTF-8');
        if ($plainRangeSet === $rangeSet) {
            if (preg_match('{^' . Rfc7233::BYTE_RANGES_SPECIFIER . '$}', $rangeSet) === 1) {
                return ByteRangeSet::fromString($rangeSet);
            }

            if (preg_match('{^' . Rfc7233::OTHER_RANGES_SPECIFIER . '$}', $rangeSet) === 1) {
                return OtherRangeSet::fromString($rangeSet);
            }
        }

        throw new InvalidArgumentException('Invalid set of ranges: ' . $rangeSet);
    }
}
