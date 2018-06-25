<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use OutOfBoundsException;
use Stadly\Http\Header\Value\MediaType;
use Stadly\Http\Header\Value\MediaType\Parameter;

/**
 * Class for handling the HTTP header field Content-Type.
 *
 * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.5
 */
final class ContentType implements HeaderInterface
{
    /**
     * @var MediaType Media type.
     */
    private $mediaType;

    /**
     * Constructor.
     *
     * @param MediaType $mediaType Media type.
     */
    public function __construct(MediaType $mediaType)
    {
        $this->mediaType = $mediaType;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName().': '.$this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Content-Type';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return (string)$this->mediaType;
    }

    /**
     * @return string Type.
     */
    public function getType(): string
    {
        return $this->mediaType->getType();
    }

    /**
     * Set type.
     *
     * @param string $type Type.
     * @throws InvalidArgumentException If the type is invalid.
     */
    public function setType(string $type): void
    {
        $this->mediaType->setType($type);
    }

    /**
     * @return string Subtype.
     */
    public function getSubtype(): string
    {
        return $this->mediaType->getSubtype();
    }

    /**
     * Set subtype.
     *
     * @param string $subtype Subtype.
     * @throws InvalidArgumentException If the subtype is invalid.
     */
    public function setSubtype(string $subtype): void
    {
        $this->mediaType->setSubtype($subtype);
    }

    /**
     * @param string $name Parameter name.
     * @return bool Whether the parameter exists.
     */
    public function hasParameter(string $name): bool
    {
        return $this->mediaType->hasParameter($name);
    }

    /**
     * @param string $name Parameter name.
     * @return Parameter Parameter.
     * @throws OutOfBoundsException If the parameter does not exist.
     */
    public function getParameter(string $name): Parameter
    {
        return $this->mediaType->getParameter($name);
    }

    /**
     * Set parameters.
     *
     * @param Parameter ...$parameters Parameters to set.
     */
    public function setParameter(Parameter ...$parameters): void
    {
        $this->mediaType->setParameter(...$parameters);
    }

    /**
     * Unset parameters.
     *
     * @param string ...$names Parameter names.
     * @throws OutOfBoundsException If a parameter does not exist.
     */
    public function unsetParameter(string ...$names): void
    {
        $this->mediaType->unsetParameter(...$names);
    }
}
