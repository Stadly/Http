<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Date;
use Stadly\Http\Utilities\Rfc7232;

/**
 * Class for handling the HTTP header field If-Unmodified-Since.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-3.4
 */
final class IfUnmodifiedSince implements Header
{
    /**
     * @var Date Date.
     */
    private $date;

    /**
     * Constructor.
     *
     * @param Date $date Date.
     */
    public function __construct(Date $date)
    {
        $this->setDate($date);
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
        $regEx = '{^' . Rfc7232::IF_UNMODIFIED_SINCE . '$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidHeader('Invalid header value: ' . $value);
        }

        return new self(Date::fromString($value));
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
        return 'If-Unmodified-Since';
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function getValue(): string
    {
        return (string)$this->date;
    }

    /**
     * @param Date|null $lastModifiedDate Last modified date, or null if unknown.
     * @return bool Whether the condition is satisfied by the last modified date.
     */
    public function evaluate(?Date $lastModifiedDate): bool
    {
        // If last modified date is unknown, the condition is not satisfied.
        if ($lastModifiedDate === null) {
            return false;
        }

        return $lastModifiedDate->isLte($this->date);
    }

    /**
     * @return Date Date.
     */
    public function getDate(): Date
    {
        return $this->date;
    }

    /**
     * Set date.
     *
     * @param Date $date Date.
     */
    public function setDate(Date $date): void
    {
        $this->date = $date;
    }
}
