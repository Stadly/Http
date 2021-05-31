<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Header\Value\EntityTag\EntityTagSet;

/**
 * Class for handling the HTTP header field If-None-Match.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-3.2
 */
final class IfNoneMatch implements Header
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
     */
    public static function fromValue(string $value): self
    {
        return new self(EntityTagSet::fromString($value));
    }

    /**
     * @inheritDoc
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
        return 'If-None-Match';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return (string)$this->entityTagSet;
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
