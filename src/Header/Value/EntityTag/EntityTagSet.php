<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\EntityTag;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Stadly\Http\Utilities\Rfc7230;
use Stadly\Http\Utilities\Rfc7232;

/**
 * Class for handling sets of entity tags.
 *
 * @implements IteratorAggregate<int, EntityTag>
 */
final class EntityTagSet implements IteratorAggregate
{
    /**
     * @var array<string, EntityTag> Entity tags.
     */
    private $entityTags = [];

    /**
     * Constructor.
     *
     * @param EntityTag ...$entityTags EntityTags. An empty entity tag set represents any entity tag (`*`).
     */
    public function __construct(EntityTag ...$entityTags)
    {
        $this->add(...$entityTags);
    }

    /**
     * Construct set of entity tags from string.
     *
     * @param string $entityTagSet Set of entity tags string.
     * @return self Set of entity tags generated based on the string.
     */
    public static function fromString(string $entityTagSet): self
    {
        if ($entityTagSet === '*') {
            return new self();
        }

        $regEx = '{^' . Rfc7230::hashRule(Rfc7232::ENTITY_TAG, 1) . '$}';
        $plainEntityTagSet = mb_convert_encoding($entityTagSet, 'ISO-8859-1', 'UTF-8');
        if ($plainEntityTagSet !== $entityTagSet || preg_match($regEx, $entityTagSet) !== 1) {
            throw new InvalidArgumentException('Invalid set of entity tags: ' . $entityTagSet);
        }

        $entityTagRegEx = '{' . Rfc7232::ENTITY_TAG_CAPTURE . '}';
        preg_match_all($entityTagRegEx, $entityTagSet, $entityTagMatches);

        $entityTags = [];
        foreach ($entityTagMatches['ENTITY_TAG'] as $entityTag) {
            $entityTags[] = EntityTag::fromString($entityTag);
        }

        return new self(...$entityTags);
    }

    /**
     * @return string String representation of the entity tag set.
     */
    public function __toString(): string
    {
        if ($this->isAny()) {
            return '*';
        }

        return implode(', ', $this->entityTags);
    }

    /**
     * @return bool Whether the entity tag set represents any entity tag.
     */
    public function isAny(): bool
    {
        return $this->entityTags === [];
    }

    /**
     * Add entity tags to the entity tag set.
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
     * Remove entity tags from the entity tag set. An empty entity tag set represents any entity tag (`*`).
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
     * Remove all entity tags from the entity tag set. The entity tag set will represent any entity tag (`*`).
     */
    public function clear(): void
    {
        $this->entityTags = [];
    }

    /**
     * @param EntityTag|null $entityTag Entity tag to compare with.
     * @return bool Whether the entity tag set matches the entity tag when using strong comparison.
     */
    public function compareStrongly(?EntityTag $entityTag): bool
    {
        if ($this->isAny()) {
            return true;
        }

        if ($entityTag === null) {
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
     * @return bool Whether the entity tag set matches the entity tag when using weak comparison.
     */
    public function compareWeakly(?EntityTag $entityTag): bool
    {
        if ($this->isAny()) {
            return true;
        }

        if ($entityTag === null) {
            return false;
        }

        foreach ($this->entityTags as $entityTagI) {
            if ($entityTag->compareWeakly($entityTagI)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ArrayIterator<int, EntityTag> Iterator containing the entity tags in the set.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(array_values($this->entityTags));
    }
}
