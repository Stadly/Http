<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\CacheControl;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling cache control directives with field list value.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2.2
 *
 * @implements IteratorAggregate<int, string>
 */
final class FieldListDirective extends Directive implements IteratorAggregate
{
    public const RESERVED_NAMES = [
        'no-cache',
        'private',
    ];

    /**
     * @var array<string, string> Field names.
     */
    private $fields = [];

    /**
     * Constructor.
     *
     * @param string $name Name.
     * @param string ...$fields Field names to include in the field list.
     */
    public function __construct(string $name, string ...$fields)
    {
        $this->setName($name);
        $this->add(...$fields);
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

        $fieldNamesRegEx = '{^' . Rfc7230::hashRule(Rfc7230::FIELD_NAME) . '$}';
        if (utf8_decode($value) !== $value || preg_match($fieldNamesRegEx, $value) !== 1) {
            throw new InvalidArgumentException('Invalid value: ' . $value);
        }

        $fieldNameRegEx = '{' . Rfc7230::FIELD_NAME_CAPTURE . '}';
        preg_match_all($fieldNameRegEx, $value, $fieldMatches);

        return new self($matches['NAME'], ...$fieldMatches['FIELD_NAME']);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->name . '="' . $this->getValue() . '"';
    }

    /**
     * @param string $name Name.
     */
    public function setName(string $name): void
    {
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc7230::TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
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
     * @return string Value.
     */
    public function getValue(): string
    {
        return implode(', ', $this->fields);
    }

    /**
     * Add field names to the field list.
     *
     * @param string ...$fields Field names to add.
     */
    public function add(string ...$fields): void
    {
        foreach ($fields as $field) {
            if (utf8_decode($field) !== $field || preg_match('{^' . Rfc7230::FIELD_NAME . '$}', $field) !== 1) {
                throw new InvalidArgumentException('Invalid field: ' . $field);
            }
        }

        foreach ($fields as $field) {
            $this->fields[strtolower($field)] = $field;
        }
    }

    /**
     * Remove field names from the field list.
     *
     * @param string ...$fields Field names to remove.
     */
    public function remove(string ...$fields): void
    {
        foreach ($fields as $field) {
            unset($this->fields[strtolower($field)]);
        }
    }

    /**
     * Remove all field names from the field list.
     */
    public function clear(): void
    {
        $this->fields = [];
    }

    /**
     * @return ArrayIterator<int, string> Iterator containing the field names in the field list.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(array_values($this->fields));
    }
}
