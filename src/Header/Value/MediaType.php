<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value;

use InvalidArgumentException;
use OutOfBoundsException;
use Stadly\Http\Header\Value\MediaType\Parameter;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7231;

/**
 * Class for handling Internet media types.
 *
 * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1
 */
final class MediaType
{
    /**
     * @var string Type.
     */
    private $type;

    /**
     * @var string Subtype.
     */
    private $subtype;

    /**
     * @var Parameter[] Parameters.
     */
    private $parameters = [];

    /**
     * Constructor.
     *
     * @param string $type Type.
     * @param string $subtype Subtype.
     * @param Parameter ...$parameters Parameters.
     */
    public function __construct(string $type, string $subtype, Parameter ...$parameters)
    {
        $this->setType($type);
        $this->setSubtype($subtype);
        $this->setParameter(...$parameters);
    }

    /**
     * Construct media type from string.
     *
     * @param string $mediaType Media type string.
     * @return self Media type generated based on the string.
     */
    public static function fromString(string $mediaType): self
    {
        $regEx = '{^'.Rfc7231::MEDIA_TYPE.'$}';
        if (utf8_decode($mediaType) !== $mediaType || 1 !== preg_match($regEx, $mediaType, $matches)) {
            throw new InvalidArgumentException("Invalid media type: $mediaType");
        }

        $parameterRexEx = '{'.Rfc7231::PARAMETER.'}';
        preg_match_all($parameterRexEx, $matches['PARAMETERS'], $parameterMatches);

        $parameters = [];
        foreach ($parameterMatches['PARAMETER'] as $parameter) {
            $parameters[] = Parameter::fromString($parameter);
        }

        return new self($matches['TYPE'], $matches['SUBTYPE'], ...$parameters);
    }

    /**
     * @return string String representation of the media type.
     */
    public function __toString(): string
    {
        $mediaType = $this->type.'/'.$this->subtype;
        if ([] !== $this->parameters) {
            $mediaType .= '; '.implode('; ', $this->parameters);
        }

        return $mediaType;
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
     * @param string $type Type.
     */
    public function setType(string $type): void
    {
        if (utf8_decode($type) !== $type || 1 !== preg_match('{^'.Rfc7231::TYPE.'$}', $type)) {
            throw new InvalidArgumentException("Invalid type: $type");
        }

        $this->type = $type;
    }

    /**
     * @return string Subtype.
     */
    public function getSubtype(): string
    {
        return $this->subtype;
    }

    /**
     * Set subtype.
     *
     * @param string $subtype Subtype.
     */
    public function setSubtype(string $subtype): void
    {
        if (utf8_decode($subtype) !== $subtype || 1 !== preg_match('{^'.Rfc7231::SUBTYPE.'$}', $subtype)) {
            throw new InvalidArgumentException("Invalid subtype: $subtype");
        }

        $this->subtype = $subtype;
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
            throw new OutOfBoundsException("Parameter not found: $name");
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
}
