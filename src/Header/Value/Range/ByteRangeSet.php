<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Stadly\Http\Utilities\Rfc7233;

/**
 * Class for handling sets of byte ranges.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-2.1
 *
 * @implements IteratorAggregate<int, ByteRange>
 */
final class ByteRangeSet implements RangeSet, IteratorAggregate
{
    /**
     * @var array<int, ByteRange> Ranges.
     */
    private $ranges = [];

    /**
     * Constructor.
     *
     * @param ByteRange ...$ranges Ranges.
     */
    public function __construct(ByteRange ...$ranges)
    {
        if (count($ranges) === 0) {
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
        $regEx = '{^' . Rfc7233::BYTE_RANGES_SPECIFIER_CAPTURE . '$}';
        $plainRangeSet = mb_convert_encoding($rangeSet, 'ISO-8859-1', 'UTF-8');
        if ($plainRangeSet !== $rangeSet || preg_match($regEx, $rangeSet, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid set of ranges: ' . $rangeSet);
        }

        $rangeRegEx = '{(?<BYTE_RANGE_SPEC>' . Rfc7233::BYTE_RANGE_SPEC . '|' . Rfc7233::SUFFIX_BYTE_RANGE_SPEC . ')}';
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
        return $this->getUnit() . '=' . $this->getValue();
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
     * @param int|null $fileSize Size of the file.
     * @return bool Whether the set of ranges is satisfiable.
     */
    public function isSatisfiable(?int $fileSize): bool
    {
        foreach ($this->ranges as $range) {
            if ($range->isSatisfiable($fileSize)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ArrayIterator<int, ByteRange> Iterator containing the ranges in the set.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->ranges);
    }
}
