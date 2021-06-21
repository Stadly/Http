<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use Cocur\Slugify\Slugify;
use InvalidArgumentException;
use OutOfBoundsException;
use Stadly\Http\Header\Value\ContentDisposition\ExtendedParameter;
use Stadly\Http\Header\Value\ContentDisposition\Parameter;
use Stadly\Http\Header\Value\ContentDisposition\RegularParameter;
use Stadly\Http\Utilities\Rfc2616;
use Stadly\Http\Utilities\Rfc6266;

/**
 * Class for handling the HTTP header field Content-Disposition.
 *
 * Specification: https://tools.ietf.org/html/rfc6266#section-4
 */
final class ContentDisposition implements Header
{
    private const INVALID_CHAR_PLACEHOLDER = '-';

    /**
     * @var string Type.
     */
    private $type;

    /**
     * @var array<Parameter> Parameters.
     */
    private $parameters = [];

    /**
     * Constructor.
     *
     * @param string $type Type. Usually `attachment` or `inline`.
     * @param Parameter ...$parameters Parameters.
     */
    public function __construct(string $type, Parameter ...$parameters)
    {
        $this->setType($type);
        $this->setParameter(...$parameters);
    }

    /**
     * Construct header from value.
     *
     * @param string $value Header value.
     * @return self Header generated based on the value.
     */
    public static function fromValue(string $value): self
    {
        $regEx = '{^' . Rfc6266::CONTENT_DISPOSITION_VALUE_CAPTURE . '$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid header value: ' . $value);
        }

        $parameters = [];
        if (isset($matches['DISPOSITION_PARAMS'])) {
            $parameterRegEx = '{' . Rfc6266::DISPOSITION_PARM_CAPTURE . '}';
            preg_match_all($parameterRegEx, $matches['DISPOSITION_PARAMS'], $parameterMatches);

            foreach ($parameterMatches['DISPOSITION_PARM'] as $parameter) {
                $parameters[] = Parameter::fromString($parameter);
            }
        }

        return new self($matches['DISPOSITION_TYPE'], ...$parameters);
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
        return 'Content-Disposition';
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function getValue(): string
    {
        $contentDisposition = $this->type;
        if ($this->parameters !== []) {
            $contentDisposition .= '; ' . implode('; ', $this->parameters);
        }

        return $contentDisposition;
    }

    /**
     * @return string Type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param string $type Type. Usually `attachment` or `inline`.
     */
    public function setType(string $type): void
    {
        if (utf8_decode($type) !== $type || preg_match('{^' . Rfc6266::DISPOSITION_TYPE . '$}', $type) !== 1) {
            throw new InvalidArgumentException('Invalid type: ' . $type);
        }

        $this->type = $type;
    }

    /**
     * @param string $name Parameter name.
     * @return bool Whether the parameter exists.
     */
    public function hasParameter(string $name): bool
    {
        return array_key_exists(strtolower($name), $this->parameters);
    }

    /**
     * @param string $name Parameter name.
     * @return Parameter Parameter.
     * @throws OutOfBoundsException If the parameter does not exist.
     */
    public function getParameter(string $name): Parameter
    {
        if (!$this->hasParameter($name)) {
            throw new OutOfBoundsException('Parameter not found: ' . $name);
        }

        return $this->parameters[strtolower($name)];
    }

    /**
     * Set parameters.
     *
     * @param Parameter ...$parameters Parameters to set.
     */
    public function setParameter(Parameter ...$parameters): void
    {
        foreach ($parameters as $parameter) {
            $this->parameters[strtolower($parameter->getName())] = $parameter;
        }
    }

    /**
     * Unset parameters.
     *
     * @param string ...$names Parameter names.
     */
    public function unsetParameter(string ...$names): void
    {
        foreach ($names as $name) {
            unset($this->parameters[strtolower($name)]);
        }
    }

    /**
     * The Content-Disposition header has two filename parameters:
     * - `filename`, which accepts only ASCII characters.
     * - `filename*`, which  accepts all characters, but is not supported by all clients.
     *
     * This method sets the `filename` parameter to an ASCII-version of the filename,
     * and additionally sets the `filename*` parameter if needed.
     *
     * @param string $filename Filename.
     */
    public function setFilename(string $filename): void
    {
        $this->unsetParameter('filename', 'filename*');

        $ascii = self::toAscii($filename);
        if ($filename === $ascii) {
            // Filename can be encoded using ASCII.
            $this->setParameter(new RegularParameter('filename', $filename));
        } else {
            // Filename cannot be encoded using ASCII.
            $this->setParameter(new RegularParameter('filename', $ascii));
            $this->setParameter(new ExtendedParameter('filename*', $filename));
        }
    }

    /**
     * Convert a string so that it contains only ASCII chars.
     *
     * @param string $string String.
     * @return string Converted string containing only ASCII chars.
     */
    private static function toAscii(string $string): string
    {
        $slugify = new Slugify([
            'regexp' => '{' . self::INVALID_CHAR_PLACEHOLDER . '}',
            'lowercase' => false,
            'trim' => false,
            'rulesets' => [
                'arabic',
                'armenian',
                'austrian',
                'azerbaijani',
                'bulgarian',
                'burmese',
                'chinese',
                'croatian',
                'czech',
                'danish',
                'default',
                'esperanto',
                'estonian',
                'finnish',
                'french',
                'georgian',
                'german',
                'greek',
                'hindi',
                'hungarian',
                'italian',
                'latvian',
                'lithuanian',
                'macedonian',
                'norwegian',
                'persian',
                'polish',
                'portuguese-brazil',
                'romanian',
                'russian',
                'serbian',
                'slovak',
                'swedish',
                'turkish',
                'turkmen',
                'ukrainian',
                'vietnamese',
            ],
        ]);

        $chars = preg_split('{}u', $string, -1, PREG_SPLIT_NO_EMPTY);
        assert($chars !== false);
        $asciiString = '';
        $lastCharIsPlaceholder = false;
        $regEx = '{^(?:' . Rfc2616::QDTEXT . '|' . Rfc2616::QUOTED_PAIR . ')+$}';
        foreach ($chars as $char) {
            $decodedChar = utf8_decode($char);

            // If the char is not ASCII, try converting it to one or more similar ASCII chars.
            if (utf8_encode($decodedChar) !== $char || preg_match($regEx, addslashes($decodedChar)) !== 1) {
                $char = $slugify->slugify($char);
                $decodedChar = utf8_decode($char);
            }

            // If the char could not be converted to ASCII, replace it with a placeholder.
            if (utf8_encode($decodedChar) !== $char || preg_match($regEx, addslashes($decodedChar)) !== 1) {
                if (!$lastCharIsPlaceholder) {
                    $asciiString .= self::INVALID_CHAR_PLACEHOLDER;
                    $lastCharIsPlaceholder = true;
                }
            } else {
                $asciiString .= $char;
                $lastCharIsPlaceholder = false;
            }
        }

        return $asciiString;
    }
}
