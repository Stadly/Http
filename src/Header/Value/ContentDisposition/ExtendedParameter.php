<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc5987;
use Stadly\Http\Utilities\Rfc6266;

/**
 * Class for handling extended content disposition parameters.
 *
 * Specification: https://tools.ietf.org/html/rfc6266#section-4.1
 */
final class ExtendedParameter extends Parameter
{
    /**
     * @var string Character set.
     */
    private $charset;

    /**
     * @var string Language.
     */
    private $language;

    /**
     * Constructor.
     *
     * @param string $name Name. Usually `filename*`.
     * @param string $value Value.
     * @param string $charset Character set.
     * @param string $language Language.
     */
    public function __construct(string $name, string $value, string $charset = 'UTF-8', string $language = '')
    {
        // Value must be a string before setting the character set.
        $this->value = '';

        $this->setName($name);
        $this->setCharset($charset);
        $this->setValue($value);
        $this->setLanguage($language);
    }

    /**
     * Construct parameter from string.
     *
     * @param string $parameter Parameter string.
     * @return self Parameter generated based on the string.
     */
    public static function fromString(string $parameter): self
    {
        $regEx = '{^' . Rfc6266::DISPOSITION_PARM_EXTENDED_CAPTURE . '$}';
        if (utf8_decode($parameter) !== $parameter || preg_match($regEx, $parameter, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid parameter: ' . $parameter);
        }

        $value = self::decodeValue($matches['VALUE_CHARS'], $matches['CHARSET']);

        return new self($matches['NAME'], $value, $matches['CHARSET'], $matches['LANGUAGE']);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $value = self::encodeValue($this->value, $this->charset);
        return $this->name . '=' . $this->charset . "'" . $this->language . "'" . $value;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        // Name must end with *.
        if (utf8_decode($name) !== $name || preg_match('{^' . Rfc6266::EXT_TOKEN . '$}', $name) !== 1) {
            throw new InvalidArgumentException('Invalid name: ' . $name);
        }

        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function setValue(string $value): void
    {
        if (!self::canEncodeValue($value, $this->charset)) {
            throw new InvalidArgumentException(
                'Value incompatible with character set ' . $this->charset . ': ' . $value
            );
        }

        $this->value = $value;
    }

    /**
     * @return string Character set.
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * @param string $charset Character set.
     */
    public function setCharset(string $charset = 'UTF-8'): void
    {
        $regEx = '{^' . Rfc5987::CHARSET . '$}';
        if (utf8_decode($charset) !== $charset || preg_match($regEx, $charset) !== 1) {
            throw new InvalidArgumentException('Invalid character set: ' . $charset);
        }

        if (!in_array(strtolower($charset), array_map('strtolower', mb_list_encodings()), /*strict*/true)) {
            throw new InvalidArgumentException('Unsupported character set' . $charset);
        }

        if (!self::canEncodeValue($this->value, $charset)) {
            throw new InvalidArgumentException(
                'Value incompatible with character set ' . $charset . ': ' . $this->value
            );
        }

        $this->charset = $charset;
    }

    /**
     * @return string Language.
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language Language.
     */
    public function setLanguage(string $language): void
    {
        // Language can be empty.
        if (utf8_decode($language) !== $language || preg_match('{^' . Rfc5987::LANGUAGE . '?$}', $language) !== 1) {
            throw new InvalidArgumentException('Invalid language: ' . $language);
        }

        $this->language = $language;
    }

    /**
     * Check if a value can be encoded using a character set.
     *
     * @param string $value Value to encode.
     * @param string $charset Character set.
     * @return bool Whether the value can be encoded using the character set.
     */
    private static function canEncodeValue(string $value, string $charset): bool
    {
        $convertedValue = mb_convert_encoding($value, $charset);
        return mb_convert_encoding($convertedValue, mb_internal_encoding(), $charset) === $value;
    }

    /**
     * @param string $value Value.
     * @param string $charset Character set.
     * @return string Encoded value.
     */
    private static function encodeValue(string $value, string $charset): string
    {
        return rawurlencode(mb_convert_encoding($value, $charset));
    }

    /**
     * @param string $value Value.
     * @param string $charset Character set.
     * @return string Decoded value.
     */
    private static function decodeValue(string $value, string $charset): string
    {
        if (!in_array(strtolower($charset), array_map('strtolower', mb_list_encodings()), /*strict*/true)) {
            throw new InvalidArgumentException('Unsupported character set' . $charset);
        }

        return mb_convert_encoding(rawurldecode($value), mb_internal_encoding(), $charset);
    }
}
