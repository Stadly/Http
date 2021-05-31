<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\MediaType;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7231;

/**
 * Class for handling media type parameters.
 *
 * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1
 */
final class Parameter
{
    /**
     * @var string Name.
     */
    private $name;

    /**
     * @var string Value.
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $name Name.
     * @param string $value Value.
     */
    public function __construct(string $name, string $value)
    {
        // Not possible to change name, since it may be used as key in arrays.
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc7230::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }
        $this->name = $name;

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
        $regEx = '{^' . Rfc7231::PARAMETER_CAPTURE . '$}';
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
     * @return string String representation of the parameter.
     */
    public function __toString(): string
    {
        return $this->name . '=' . self::encodeValue($this->value);
    }

    /**
     * @return string Name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string Value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value Value.
     */
    public function setValue(string $value): void
    {
        $encodedValue = self::encodeValue($value);

        $regEx = '{^(?:' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . ')$}';
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
        if (preg_match('{^' . Rfc7230::TOKEN . '$}', $value) === 1) {
            return $value;
        }

        // If value is not a valid token, turn it into a quoted token.
        return '"' . addslashes($value) . '"';
    }
}
