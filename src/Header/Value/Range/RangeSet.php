<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

/**
 * Interface to be implemented by all range sets.
 */
interface RangeSet
{
    /**
     * @return string String representation of the range set.
     */
    public function __toString(): string;

    /**
     * @return string Unit.
     */
    public function getUnit(): string;

    /**
     * @return string Value.
     */
    public function getValue(): string;
}
