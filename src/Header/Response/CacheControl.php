<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use OutOfBoundsException;
use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\CacheControl\Directive;
use Stadly\Http\Utilities\Rfc7234;

/**
 * Class for handling the HTTP header field Cache-Control.
 *
 * Specification: https://tools.ietf.org/html/rfc7234#section-5.2
 */
final class CacheControl implements Header
{
    /**
     * @var array<Directive> Directives.
     */
    private $directives = [];

    /**
     * Constructor.
     *
     * @param Directive ...$directives Directives.
     */
    public function __construct(Directive ...$directives)
    {
        $this->setDirective(...$directives);
    }

    /**
     * Construct header from value.
     *
     * @param string $value Header value.
     * @return self Header generated based on the value.
     * @throws InvalidHeader If the header value is invalid.
     */
    public static function fromValue(string $value): self
    {
        $regEx = '{^' . Rfc7234::CACHE_CONTROL . '$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidHeader('Invalid header value: ' . $value);
        }

        $directiveRegEx = '{' . Rfc7234::CACHE_DIRECTIVE_CAPTURE . '}';
        preg_match_all($directiveRegEx, $value, $matches);

        $directives = [];
        foreach ($matches['CACHE_DIRECTIVE'] as $directive) {
            $directives[] = Directive::fromString($directive);
        }

        return new self(...$directives);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName() . ': ' . $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->directives !== [];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Cache-Control';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        if ($this->directives === []) {
            throw new InvalidHeader('Header has no directives.');
        }

        return implode(', ', $this->directives);
    }

    /**
     * @param string $name Directive name.
     * @return bool Whether the directive exists.
     */
    public function hasDirective(string $name): bool
    {
        return array_key_exists(strtolower($name), $this->directives);
    }

    /**
     * @param string $name Directive name.
     * @return Directive Directive.
     * @throws OutOfBoundsException If the directive does not exist.
     */
    public function getDirective(string $name): Directive
    {
        if (!$this->hasDirective($name)) {
            throw new OutOfBoundsException('Directive not found: ' . $name);
        }

        return $this->directives[strtolower($name)];
    }

    /**
     * Set directives.
     *
     * @param Directive ...$directives Directives to set.
     */
    public function setDirective(Directive ...$directives): void
    {
        foreach ($directives as $directive) {
            $this->directives[strtolower($directive->getName())] = $directive;
        }
    }

    /**
     * Unset directives.
     *
     * @param string ...$names Directive names.
     */
    public function unsetDirective(string ...$names): void
    {
        foreach ($names as $name) {
            unset($this->directives[strtolower($name)]);
        }
    }
}
