<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use Stadly\Http\Header\Value\EntityTag\EntityTag;

/**
 * Class for handling the HTTP header field ETag.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-2.3
 */
final class ETag implements Header
{
    /**
     * @var EntityTag Entity tag.
     */
    private $entityTag;

    /**
     * Constructor.
     *
     * @param EntityTag $entityTag Entity tag.
     */
    public function __construct(EntityTag $entityTag)
    {
        $this->setEntityTag($entityTag);
    }

    /**
     * Construct header from value.
     *
     * @param string $value Header value.
     * @return self Header generated based on the value.
     */
    public static function fromValue(string $value): self
    {
        return new self(EntityTag::fromString($value));
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
        return 'ETag';
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function getValue(): string
    {
        return (string)$this->entityTag;
    }

    /**
     * @return EntityTag Entity tag.
     */
    public function getEntityTag(): EntityTag
    {
        return $this->entityTag;
    }

    /**
     * Set entity tag.
     *
     * @param EntityTag $entityTag Entity tag.
     */
    public function setEntityTag(EntityTag $entityTag): void
    {
        $this->entityTag = $entityTag;
    }
}
