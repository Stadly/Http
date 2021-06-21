<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;

/**
 * Class for handling general HTTP header fields.
 *
 * Specification: https://tools.ietf.org/html/rfc7230#section-3.2
 */
final class ArbitraryHeader implements Header
{
    /**
     * @var string Header field name.
     */
    private $name;

    /**
     * @var string Header field value.
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $name Header field name.
     * @param string $value Header field value.
     */
    public function __construct(string $name, string $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Construct header from string.
     *
     * @param string $header Header field string.
     * @return self Header generated based on the string.
     */
    public static function fromString(string $header): self
    {
        $regEx = '{^' . Rfc7230::HEADER_FIELD_CAPTURE . '$}';
        if (utf8_decode($header) !== $header || preg_match($regEx, $header, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid header field: ' . $header);
        }

        return new self($matches['FIELD_NAME'], $matches['FIELD_VALUE']);
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function __toString(): string
    {
        return $this->getName() . ': ' . $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set header field name.
     *
     * @param string $name Header field name.
     */
    public function setName(string $name): void
    {
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc7230::FIELD_NAME . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid header field name: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * Set header field value.
     *
     * @param string $value Header field value.
     */
    public function setValue(string $value): void
    {
        if (utf8_decode($value) !== $value || preg_match('{^' . Rfc7230::FIELD_VALUE . '$}', $value) !== 1) {
            throw new InvalidArgumentException('Invalid header field value: ' . $value);
        }

        $this->value = $value;
    }
}
