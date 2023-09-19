<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling cache control directives with optional value.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2.2
 */
final class GeneralDirective extends Directive
{
    /**
     * @var string|null Value.
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $name Name.
     * @param string|null $value Value.
     */
    public function __construct(string $name, ?string $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Construct directive from string.
     *
     * @param string $directive Directive string.
     * @return self Directive generated based on the string.
     */
    public static function fromString(string $directive): self
    {
        $regEx = '{^' . Rfc7234::CACHE_DIRECTIVE_CAPTURE . '$}';
        $plainDirective = mb_convert_encoding($directive, 'ISO-8859-1', 'UTF-8');
        if ($plainDirective !== $directive || preg_match($regEx, $directive, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid directive: ' . $directive);
        }

        if (!isset($matches['VALUE'])) {
            return new self($matches['NAME'], /*value*/null);
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
        if ($this->value === null) {
            return $this->name;
        }

        return $this->name . '=' . self::encodeValue($this->value);
    }

    /**
     * @param string $name Name.
     */
    public function setName(string $name): void
    {
        $plainName = mb_convert_encoding($name, 'ISO-8859-1', 'UTF-8');
        if ($plainName !== $name || preg_match('{^' . Rfc7230::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }

        if (in_array(strtolower($name), FieldListDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for field list directive: ' . $name);
        }
        if (in_array(strtolower($name), IntegerDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for integer directive: ' . $name);
        }
        if (in_array(strtolower($name), ValuelessDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for valueless directive: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value Value.
     */
    public function setValue(?string $value): void
    {
        if ($value !== null) {
            $encodedValue = self::encodeValue($value);

            $regEx = '{^(?:' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . ')$}';
            $plainValue = mb_convert_encoding($encodedValue, 'ISO-8859-1', 'UTF-8');
            if ($plainValue !== $encodedValue || preg_match($regEx, $encodedValue) !== 1) {
                throw new InvalidArgumentException('Invalid value: ' . $value);
            }
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
