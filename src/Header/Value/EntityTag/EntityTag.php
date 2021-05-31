<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\EntityTag;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7232;

/**
 * Class for handling entity tags.
 *
 * Specification: https://tools.ietf.org/html/rfc7232#section-2.3
 */
final class EntityTag
{
    /**
     * @var string Entity tag value.
     */
    private $value;

    /**
     * @var bool Whether the entity tag is a weak validator.
     */
    private $isWeak;

    /**
     * Constructor.
     *
     * @param string $value Entity tag value.
     * @param bool $isWeak Whether the entity tag is a weak validator.
     */
    public function __construct(string $value, bool $isWeak = false)
    {
        // Not possible to change value, since it may be used as key in arrays.
        if (utf8_decode($value) !== $value || preg_match('{^' . Rfc7232::ETAGC . '*$}', $value) !== 1) {
            throw new InvalidArgumentException('Invalid entity tag: ' . $value);
        }
        $this->value = $value;

        $this->setWeak($isWeak);
    }

    /**
     * Construct entity tag from string.
     *
     * @param string $entityTag Entity tag string.
     * @return self Entity tag generated based on the string.
     */
    public static function fromString(string $entityTag): self
    {
        $regEx = '{^' . Rfc7232::ENTITY_TAG_CAPTURE . '$}';
        if (utf8_decode($entityTag) !== $entityTag || preg_match($regEx, $entityTag, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid entity tag: ' . $entityTag);
        }

        return new self($matches['ETAGCS'], preg_match('{^' . Rfc7232::WEAK . '$}', $matches['WEAK']) === 1);
    }

    /**
     * @return string String representation of the entity tag.
     */
    public function __toString(): string
    {
        $entityTag = '';

        if ($this->isWeak) {
            $entityTag .= 'W/';
        }

        $entityTag .= '"' . $this->value . '"';

        return $entityTag;
    }

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.1
     *
     * @return bool Whether the entity tag is a weak validator.
     */
    public function isWeak(): bool
    {
        return $this->isWeak;
    }

    /**
     * @param bool $isWeak Whether the entity tag is a weak validator.
     */
    public function setWeak(bool $isWeak): void
    {
        $this->isWeak = $isWeak;
    }

    /**
     * @return string Entity tag value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3.2
     *
     * @param self $entityTag Entity tag to compare with.
     * @return bool Whether the entity tags match each other, using strong comparison.
     */
    public function compareStrongly(self $entityTag): bool
    {
        return !$this->isWeak && !$entityTag->isWeak && $this->value === $entityTag->value;
    }

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3.2
     *
     * @param self $entityTag Entity tag to compare with.
     * @return bool Whether the entity tags match each other, using weak comparison.
     */
    public function compareWeakly(self $entityTag): bool
    {
        return $this->value === $entityTag->value;
    }
}
