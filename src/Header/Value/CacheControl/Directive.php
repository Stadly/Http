<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling cache control directives.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2.2
 */
abstract class Directive
{
    /**
     * @var string Name.
     */
    protected $name;

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

        $name = strtolower($matches['NAME']);

        if (in_array($name, FieldListDirective::RESERVED_NAMES, /*strict*/true)) {
            return FieldListDirective::fromString($directive);
        }
        if (in_array($name, IntegerDirective::RESERVED_NAMES, /*strict*/true)) {
            return IntegerDirective::fromString($directive);
        }
        if (in_array($name, ValuelessDirective::RESERVED_NAMES, /*strict*/true)) {
            return ValuelessDirective::fromString($directive);
        }

        return GeneralDirective::fromString($directive);
    }

    /**
     * @return string String representation of the directive.
     */
    abstract public function __toString(): string;

    /**
     * @return string Name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name Name.
     */
    abstract public function setName(string $name): void;

    /**
     * @return string|null Value.
     */
    abstract public function getValue(): ?string;
}
