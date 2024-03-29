<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\MediaType\MediaType;
use Stadly\Http\Utilities\Rfc7231;

/**
 * Class for handling the HTTP header field Content-Type.
 *
 * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.5
 */
final class ContentType implements Header
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
     * Construct header from value.
     *
     * @param string $value Header value.
     * @return self Header generated based on the value.
     * @throws InvalidHeader If the header value is invalid.
     */
    public static function fromValue(string $value): self
    {
        $regEx = '{^' . Rfc7231::CONTENT_TYPE . '$}';
        $plainValue = mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
        if ($plainValue !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidHeader('Invalid header value: ' . $value);
        }

        return new self(MediaType::fromString($value));
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
        return 'Content-Type';
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
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
