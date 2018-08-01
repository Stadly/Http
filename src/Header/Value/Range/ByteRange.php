<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\Range;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7233;

/**
 * Class for handling byte ranges.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-2.1
 */
final class ByteRange
{
    /**
     * @var int|null Position of first byte in range.
     */
    private $firstByte;

    /**
     * @var int|null Position of last byte in range.
     */
    private $lastByte;

    /**
     * Constructor.
     *
     * @param int|null $firstByte Position of first byte in range, null covers from end of file.
     * @param int|null $lastByte Position of last byte in range, null covers to end of file.
     */
    public function __construct(?int $firstByte, ?int $lastByte)
    {
        // Both $firstByte and $lastByte are null.
        if (null === $firstByte && null === $lastByte) {
            throw new InvalidArgumentException("Invalid range: $firstByte-$lastByte");
        }

        // $firstByte or $lastByte are negative.
        if ($firstByte < 0 || $lastByte < 0) {
            throw new InvalidArgumentException("Invalid range: $firstByte-$lastByte");
        }

        // $lastByte is before $firstByte.
        if (null !== $lastByte && $lastByte < $firstByte) {
            throw new InvalidArgumentException("Invalid range: $firstByte-$lastByte");
        }

        $this->firstByte = $firstByte;
        $this->lastByte = $lastByte;
    }

    /**
     * Construct range from string.
     *
     * @param string $range Range string.
     * @return self Range generated based on the string.
     */
    public static function fromString(string $range): self
    {
        $regEx = '{^(?:'.Rfc7233::BYTE_RANGE_SPEC_CAPTURE.'|'.Rfc7233::SUFFIX_BYTE_RANGE_SPEC_CAPTURE.')$}';
        if (utf8_decode($range) !== $range || 1 !== preg_match($regEx, $range, $matches)) {
            throw new InvalidArgumentException("Invalid range: $range");
        }

        $firstByte = '' === $matches['FIRST_BYTE_POS'] ? null : intval($matches['FIRST_BYTE_POS']);

        if (null === $firstByte) {
            $lastByte = intval($matches['SUFFIX_LENGTH']);
        } else {
            $lastByte = '' === ($matches['LAST_BYTE_POS'] ?? '') ? null : intval($matches['LAST_BYTE_POS']);
        }

        return new self($firstByte, $lastByte);
    }

    /**
     * @return string String representation of the range.
     */
    public function __toString(): string
    {
        return "$this->firstByte-$this->lastByte";
    }

    /**
     * @param int|null $size Size of the file.
     * @return bool Whether the range is satisfiable.
     */
    public function isSatisfiable(?int $size): bool
    {
        if (null === $this->firstByte)
            return 0 < $this->lastByte;

        // If file size is unknown, assume the range is satisfiable.
        return null === $size || $this->firstByte < $size;
    }
}
