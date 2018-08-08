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
     * @param int|null $fileSize Size of the file.
     * @return bool Whether the range is satisfiable.
     */
    public function isSatisfiable(?int $fileSize): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        // Cannot cover from or to end of file when file size is unkown.
        if (null === $fileSize && (null === $this->firstByte || null === $this->lastByte)) {
            return false;
        }

        // Number of bytes must be positive when covering from the end.
        if (null === $this->firstByte) {
            return 0 < $this->lastByte;
        }

        // If file size is unknown, assume the range is satisfiable.
        return null === $fileSize || $this->firstByte < $fileSize;
    }

    /**
     * @return bool Whether the range is valid.
     */
    public function isValid(): bool
    {
        return null === $this->lastByte || $this->firstByte <= $this->lastByte;
    }

    /**
     * @param int|null $fileSize Size of the file.
     * @return int Position of the first byte in the range.
     */
    public function getFirstBytePos(?int $fileSize): int
    {
        // File size and number of bytes must be positive when covering from the end.
        if (null === $this->firstByte && null !== $fileSize && 0 < $fileSize && 0 < $this->lastByte) {
            assert(null !== $this->lastByte);
            return max(0, $fileSize-$this->lastByte);
        }

        // First byte must be smaller than file size, unless file size is unknown.
        if (null !== $this->firstByte && (null === $fileSize || $this->firstByte < $fileSize)) {
            return $this->firstByte;
        }

        throw new InvalidArgumentException(sprintf(
            'Cannot calculate first byte position: %s-%s/%s',
            $this->firstByte,
            $this->lastByte,
            $fileSize ?? '*'
        ));
    }

    /**
     * @param int|null $fileSize Size of the file.
     * @return int Position of the last byte in the range.
     */
    public function getLastBytePos(?int $fileSize): int
    {
        if (null === $fileSize) {
            // When file size is unknown, both first byte and last byte must be specified.
            if (null !== $this->firstByte && null !== $this->lastByte) {
                return $this->lastByte;
            }
        } elseif (0 < $fileSize) {
            if (null === $this->firstByte) {
                // When covering from the end, the number of bytes covered must be positive.
                if (0 < $this->lastByte) {
                    return $fileSize-1;
                }
            // First byte must be smaller than file size.
            } elseif ($this->firstByte < $fileSize) {
                return min($this->lastByte ?? $fileSize-1, $fileSize-1);
            }
        }

        throw new InvalidArgumentException(sprintf(
            'Cannot calculate last byte position: %s-%s/%s',
            $this->firstByte,
            $this->lastByte,
            $fileSize ?? '*'
        ));
    }

    /**
     * @param int|null $fileSize Size of the file.
     * @return int Number of bytes in the range.
     */
    public function getLength(?int $fileSize): int
    {
        return $this->getLastBytePos($fileSize) - $this->getFirstBytePos($fileSize) + 1;
    }

    /**
     * @param int|null $fileSize Size of the file.
     * @return bool Whether the range covers the entire file.
     */
    public function coversFile(?int $fileSize): bool
    {
        if (null === $this->lastByte) {
            return 0 === $this->firstByte;
        }

        if (null !== $fileSize) {
            if (0 === $this->firstByte && $fileSize <= $this->lastByte+1) {
                return true;
            }

            if (null === $this->firstByte && $fileSize <= $this->lastByte) {
                return true;
            }
        }

        return false;
    }
}
