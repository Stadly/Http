<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Header\Value\EntityTag;

/**
 * Class for handling the HTTP header field If-Match.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-3.1
 */
final class IfMatch implements HeaderInterface
{
    /**
     * @var EntityTag[] Entity tags.
     */
    private $entityTags = [];

    /**
     * Constructor.
     *
     * @param EntityTag ...$entityTags EntityTags. If no entity tags are provided, it matches anything.
     */
    public function __construct(EntityTag ...$entityTags)
    {
        $this->add(...$entityTags);
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
        return 'If-Match';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        if ($this->isAny()) {
            return '*';
        }

        return implode(', ', $this->entityTags);
    }

    /**
     * @return bool Whether the If-Match header field is any entity tag.
     */
    public function isAny(): bool
    {
        return [] === $this->entityTags;
    }

    /**
     * Add entity tags to the If-Match header field.
     *
     * @param EntityTag ...$entityTags Entity tags to add.
     */
    public function add(EntityTag ...$entityTags): void
    {
        foreach ($entityTags as $entityTag) {
            $this->entityTags[$entityTag->getValue()] = $entityTag;
        }
    }

    /**
     * Remove entity tags from the If-Match header field.
     * Specify entity tag values that should be removed, such as `foo`, not `W/"foo"`.
     *
     * @param string ...$values Entity tag values to remove.
     */
    public function remove(string ...$values): void
    {
        foreach ($values as $value) {
            unset($this->entityTags[$value]);
        }
    }

    /**
     * Remove all entity tags from the If-Match header field.
     */
    public function clear(): void
    {
        $this->entityTags = [];
    }

    /**
     * @param EntityTag|null $entityTag Entity tag to compare with.
     * @return bool Whether the If-Match header field matches the entity tag when using strong comparison.
     */
    public function compareStrongly(?EntityTag $entityTag): bool
    {
        if ($this->isAny()) {
            return true;
        }
        
        if (null === $entityTag) {
            return false;
        }
        
        foreach ($this->entityTags as $entityTagI) {
            if ($entityTag->compareStrongly($entityTagI)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param EntityTag|null $entityTag Entity tag to compare with.
     * @return bool Whether the If-Match header field matches the entity tag when using weak comparison.
     */
    public function compareWeakly(?EntityTag $entityTag): bool
    {
        if ($this->isAny()) {
            return true;
        }

        if (null === $entityTag) {
            return false;
        }
        
        foreach ($this->entityTags as $entityTagntityTagI) {
            if ($entityTag->compareWeakly($entityTagntityTagI)) {
                return true;
            }
        }

        return false;
    }
}
