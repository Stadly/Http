<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\EntityTag\EntityTag;
use Stadly\Http\Header\Value\EntityTag\EntityTagSet;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7232;

/**
 * Class for handling the HTTP header field If-Match.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-3.1
 */
final class IfMatch implements Header
{
    /**
     * @var EntityTagSet Entity tag set.
     */
    private $entityTagSet;

    /**
     * Constructor.
     *
     * @param EntityTagSet $entityTagSet Set of entity tags.
     */
    public function __construct(EntityTagSet $entityTagSet)
    {
        $this->setEntityTagSet($entityTagSet);
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
        $regEx = '{^(?:\\*|' . Rfc7230::hashRule(Rfc7232::ENTITY_TAG, 1) . ')$}';
        if (utf8_decode($value) !== $value || preg_match($regEx, $value) !== 1) {
            throw new InvalidHeader('Invalid header value: ' . $value);
        }

        return new self(EntityTagSet::fromString($value));
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
        return 'If-Match';
    }

    /**
     * @inheritDoc
     * @throws void The header is always valid.
     */
    public function getValue(): string
    {
        return (string)$this->entityTagSet;
    }

    /**
     * @param EntityTag|null $entityTag Entity tag to evaluate.
     * @return bool Whether the entity tag set strongly matches the entity tag.
     */
    public function evaluate(?EntityTag $entityTag): bool
    {
        return $this->entityTagSet->compareStrongly($entityTag);
    }

    /**
     * @return EntityTagSet Set of entity tags.
     */
    public function getEntityTagSet(): EntityTagSet
    {
        return $this->entityTagSet;
    }

    /**
     * Set entity tag set.
     *
     * @param EntityTagSet $entityTagSet Set of entity tags.
     */
    public function setEntityTagSet(EntityTagSet $entityTagSet): void
    {
        $this->entityTagSet = $entityTagSet;
    }
}
