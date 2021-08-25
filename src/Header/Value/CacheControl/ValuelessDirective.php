<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling cache control directives without value.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2.2
 */
final class ValuelessDirective extends Directive
{
    public const RESERVED_NAMES = [
        'must-revalidate',
        'no-store',
        'no-transform',
        'public',
        'proxy-revalidate',
    ];

    /**
     * Constructor.
     *
     * @param string $name Name.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
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

        if (isset($matches['VALUE'])) {
            throw new InvalidArgumentException('Invalid value: ' . $matches['VALUE']);
        }

        return new self($matches['NAME']);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc7230::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }

        if (in_array(strtolower($name), FieldListDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for field list directive: ' . $name);
        }
        if (in_array(strtolower($name), IntegerDirective::RESERVED_NAMES, /*strict*/true)) {
            throw new InvalidArgumentException('Name reserved for integer directive: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * @return null Value.
     */
    public function getValue(): ?string
    {
        return null;
    }
}
