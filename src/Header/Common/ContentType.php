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
        $this->setMediaType($mediaType);
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
     * @return MediaType Media type.
     */
    public function getMediaType(): MediaType
    {
        return $this->mediaType;
    }

    /**
     * Set media type.
     *
     * @param MediaType $mediaType Media type.
     */
    public function setMediaType(MediaType $mediaType): void
    {
        $this->mediaType = $mediaType;
    }
}
