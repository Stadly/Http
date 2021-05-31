<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7233;

/**
 * Class for handling sets of other ranges.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-3.1
 */
final class OtherRangeSet implements RangeSet
{
    /**
     * @var string Unit.
     */
    private $unit;

    /**
     * @var string Value.
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $unit Unit.
     * @param string $value Value.
     */
    public function __construct(string $unit, string $value)
    {
        $this->setUnit($unit);
        $this->setValue($value);
    }

    /**
     * Construct set of ranges from string.
     *
     * @param string $rangeSet Set of ranges string.
     * @return self Set of ranges generated based on the string.
     */
    public static function fromString(string $rangeSet): self
    {
        $regEx = '{^' . Rfc7233::OTHER_RANGES_SPECIFIER_CAPTURE . '$}';
        if (utf8_decode($rangeSet) !== $rangeSet || preg_match($regEx, $rangeSet, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid set of ranges: ' . $rangeSet);
        }

        return new self($matches['OTHER_RANGE_UNIT'], $matches['OTHER_RANGE_SET']);
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
        return $this->unit;
    }

    /**
     * Set unit.
     *
     * @param string $unit Unit.
     */
    public function setUnit(string $unit): void
    {
        if (utf8_decode($unit) !== $unit || preg_match('{^' . Rfc7233::OTHER_RANGE_UNIT . '$}', $unit) !== 1) {
            throw new InvalidArgumentException('Invalid unit: ' . $unit);
        }

        $this->unit = $unit;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string $value Value.
     */
    public function setValue(string $value): void
    {
        if (utf8_decode($value) !== $value || preg_match('{^' . Rfc7233::OTHER_RANGE_SET . '$}', $value) !== 1) {
            throw new InvalidArgumentException('Invalid value: ' . $value);
        }

        $this->value = $value;
    }
}
