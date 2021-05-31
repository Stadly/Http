<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Header\Value\Range\RangeSet;
use Stadly\Http\Header\Value\Range\RangeSetFactory;

/**
 * Class for handling the HTTP header field Range.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-3.1
 */
final class Range implements Header
{
    /**
     * @var RangeSet Range set.
     */
    private $rangeSet;

    /**
     * Constructor.
     *
     * @param RangeSet $rangeSet Set of ranges.
     */
    public function __construct(RangeSet $rangeSet)
    {
        $this->setRangeSet($rangeSet);
    }

    /**
     * Construct header from value.
     *
     * @param string $value Header value.
     * @return self Header generated based on the value.
     */
    public static function fromValue(string $value): self
    {
        return new self(RangeSetFactory::fromString($value));
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName() . ': ' . $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Range';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return (string)$this->rangeSet;
    }

    /**
     * @return RangeSet Set of ranges.
     */
    public function getRangeSet(): RangeSet
    {
        return $this->rangeSet;
    }

    /**
     * Set range set.
     *
     * @param RangeSet $rangeSet Set of ranges.
     */
    public function setRangeSet(RangeSet $rangeSet): void
    {
        $this->rangeSet = $rangeSet;
    }
}
