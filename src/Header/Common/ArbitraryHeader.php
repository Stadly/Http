<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use Stadly\Http\Exception\InvalidHeader;
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
     * @throws InvalidHeader If the header is invalid.
     */
    public static function fromString(string $header): self
    {
        $regEx = '{^' . Rfc7230::HEADER_FIELD_CAPTURE . '$}';
        $plainHeader = mb_convert_encoding($header, 'ISO-8859-1', 'UTF-8');
        if ($plainHeader !== $header || preg_match($regEx, $header, $matches) !== 1) {
            throw new InvalidHeader('Invalid header field: ' . $header);
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
     * @return true The header is always valid.
     */
    public function isValid(): bool
    {
        return true;
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
        $plainName = mb_convert_encoding($name, 'ISO-8859-1', 'UTF-8');
        if ($plainName !== $name || preg_match('{^' . Rfc7230::FIELD_NAME . '$}', $name) !== 1) {
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
        $plainValue = mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
        if ($plainValue !== $value || preg_match('{^' . Rfc7230::FIELD_VALUE . '$}', $value) !== 1) {
            throw new InvalidArgumentException('Invalid header field value: ' . $value);
        }

        $this->value = $value;
    }
}
