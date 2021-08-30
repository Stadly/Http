<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Range\RangeSet;
use Stadly\Http\Header\Value\Range\RangeSetFactory;
use Stadly\Http\Utilities\Rfc7233;

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
     * @throws InvalidHeader If the header value is invalid.
     */
    public static function fromValue(string $value): self
    {
        $regEx = '{^(?:' . Rfc7233::BYTE_RANGES_SPECIFIER . '|' . Rfc7233::OTHER_RANGES_SPECIFIER . ')$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidHeader('Invalid header value: ' . $value);
        }

        return new self(RangeSetFactory::fromString($value));
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function __toString(): string
    {
        return $this->getName() . ': ' . $this->getValue();
    }

    /**
     * @return true The header is always valid.
     */
    public function isValid(): bool
    {
        return true;
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
     * @throws void The header is always valid.
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
