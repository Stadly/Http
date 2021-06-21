<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc2616;
use Stadly\Http\Utilities\Rfc6266;

/**
 * Class for handling regular content disposition parameters.
 *
 * Specification: https://tools.ietf.org/html/rfc6266#section-4.1
 */
final class RegularParameter extends Parameter
{
    /**
     * Constructor.
     *
     * @param string $name Name. Usually `filename`.
     * @param string $value Value.
     */
    public function __construct(string $name, string $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Construct parameter from string.
     *
     * @param string $parameter Parameter string.
     * @return self Parameter generated based on the string.
     */
    public static function fromString(string $parameter): self
    {
        $regEx = '{^' . Rfc6266::DISPOSITION_PARM_REGULAR_CAPTURE . '$}';
        if (utf8_decode($parameter) !== $parameter || preg_match($regEx, $parameter, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid parameter: ' . $parameter);
        }

        $value = $matches['VALUE'];
        // Strip slashes if value is quoted.
        if (mb_strlen($value) >= 2 && mb_substr($value, 0, 1) === '"' && mb_substr($value, -1) === '"') {
            $value = stripslashes(mb_substr($value, 1, -1));
        }

        return new self($matches['NAME'], $value);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->name . '=' . self::encodeValue($this->value);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc2616::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function setValue(string $value): void
    {
        $encodedValue = self::encodeValue($value);

        $regEx = '{^' . Rfc2616::VALUE . '$}';
        if (utf8_decode($encodedValue) !== $encodedValue || preg_match($regEx, $encodedValue) !== 1) {
            throw new InvalidArgumentException('Invalid value: ' . $value);
        }

        $this->value = $value;
    }

    /**
     * @param string $value Value.
     * @return string Encoded value.
     */
    private static function encodeValue(string $value): string
    {
        if (preg_match('{^' . Rfc2616::TOKEN . '$}', $value) === 1) {
            return $value;
        }

        // If value is not a valid token, turn it into a quoted token.
        return '"' . addslashes($value) . '"';
    }
}
