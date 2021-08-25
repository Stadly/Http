<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling cache control directives with integer value.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2.2
 */
final class IntegerDirective extends Directive
{
    public const RESERVED_NAMES = [
        'max-age',
        's-maxage',
    ];

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
        if (utf8_decode($directive) !== $directive || preg_match($regEx, $directive, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid directive: ' . $directive);
        }

        if (!isset($matches['VALUE'])) {
            throw new InvalidArgumentException('Directive must have value');
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
        return $this->name . '=' . $this->value;
    }

    /**
     * @param string $name Name.
     */
    public function setName(string $name): void
    {
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc7230::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }

        if (in_array(strtolower($name), FieldListDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for field list directive: ' . $name);
        }
        if (in_array(strtolower($name), ValuelessDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for valueless directive: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * @return string Value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set the value. It must be a non-negative integer string.
     *
     * @param string $value Value.
     */
    public function setValue(string $value): void
    {
        $regEx = '{^' . Rfc7234::DELTA_SECONDS . '$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidArgumentException('Invalid value: ' . $value);
        }

        $this->value = $value;
    }
}
