<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7231;

/**
 * Class for handling dates.
 *
 * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1
 */
final class Date
{
    public static function fromString(string $date): self
    {
        return new self();
    }

    public static function fromTimestamp(float $timestamp): self
    {
        return new self();
    }

    public function __toString(): string
    {
        return '';
    }

    public function isWeak(): bool
    {
        return false;
    }

    public function isLt(self $date): bool
    {
        return false;
    }

    public function isLte(self $date): bool
    {
        return false;
    }

    public function isEq(self $date): bool
    {
        return false;
    }

    public function isGte(self $date): bool
    {
        return false;
    }

    public function isGt(self $date): bool
    {
        return false;
    }
}
