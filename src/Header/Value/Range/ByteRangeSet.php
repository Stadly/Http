<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7233;

/**
 * Class for handling sets of byte ranges.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-2.1
 */
final class ByteRangeSet implements RangeSetInterface
{
    /**
     * @var ByteRange[] Ranges.
     */
    private $ranges = [];

    /**
     * Constructor.
     *
     * @param ByteRange ...$ranges Ranges.
     */
    public function __construct(ByteRange ...$ranges)
    {
        if (0 === count($ranges)) {
            throw new InvalidArgumentException('The set of ranges cannot be empty.');
        }

        $this->add(...$ranges);
    }

    /**
     * Construct set of byte ranges from string.
     *
     * @param string $rangeSet Set of ranges string.
     * @return self Set of byte ranges generated based on the string.
     */
    public static function fromString(string $rangeSet): self
    {
        $regEx = '{^'.Rfc7233::BYTE_RANGES_SPECIFIER_CAPTURE.'$}';
        if (utf8_decode($rangeSet) !== $rangeSet || 1 !== preg_match($regEx, $rangeSet, $matches)) {
            throw new InvalidArgumentException("Invalid set of ranges: $rangeSet");
        }

        $rangeRegEx = '{(?<BYTE_RANGE_SPEC>'.Rfc7233::BYTE_RANGE_SPEC.'|'.Rfc7233::SUFFIX_BYTE_RANGE_SPEC.')}';
        preg_match_all($rangeRegEx, $matches['BYTE_RANGE_SET'], $rangeMatches);

        $ranges = [];
        foreach ($rangeMatches['BYTE_RANGE_SPEC'] as $range) {
            $ranges[] = ByteRange::fromString($range);
        }

        return new self(...$ranges);
    }

    /**
     * @return string String representation of the range set.
     */
    public function __toString(): string
    {
        return $this->getUnit().'='.$this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getUnit(): string
    {
        return 'bytes';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return implode(', ', $this->ranges);
    }

    /**
     * Add ranges to the range set.
     *
     * @param ByteRange ...$ranges Ranges to add.
     */
    public function add(ByteRange ...$ranges): void
    {
        foreach ($ranges as $range) {
            $this->ranges[] = $range;
        }
    }

    /**
     * @param int|null $size Size of the file.
     * @return bool Whether the set of ranges is satisfiable.
     */
    public function isSatisfiable($size): bool
    {
        foreach ($this->ranges as $range) {
            if ($range->isSatisfiable($size))
                return true;
        }

        return false;
    }
}
