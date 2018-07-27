<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Header\Value\Range\RangeSetInterface;

/**
 * Class for handling the HTTP header field Range.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-3.1
 */
final class Range implements HeaderInterface
{
    /**
     * @var RangeSetInterface Range set.
     */
    private $rangeSet;

    /**
     * Constructor.
     *
     * @param RangeSetInterface $rangeSet Set of ranges.
     */
    public function __construct(RangeSetInterface $rangeSet)
    {
        $this->setRangeSet($rangeSet);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName().': '.$this->getValue();
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
     * @return RangeSetInterface Set of ranges.
     */
    public function getRangeSet(): RangeSetInterface
    {
        return $this->rangeSet;
    }

    /**
     * Set range set.
     *
     * @param RangeSetInterface $rangeSet Set of ranges.
     */
    public function setRangeSet(RangeSetInterface $rangeSet): void
    {
        $this->rangeSet = $rangeSet;
    }
}
