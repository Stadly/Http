<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use Stadly\Http\Exception\InvalidHeader;
use Stadly\Http\Header\Value\Date;
use Stadly\Http\Header\Value\EntityTag\EntityTag;
use Stadly\Http\Utilities\Rfc7231;
use Stadly\Http\Utilities\Rfc7232;

/**
 * Class for handling the HTTP header field If-Range.
 *
 * Specification: https://tools.ietf.org/html/rfc7233#section-3.2
 */
final class IfRange implements Header
{
    /**
     * @var EntityTag|Date Strong validator.
     */
    private $validator;

    /**
     * Constructor.
     *
     * @param EntityTag|Date $validator Strong validator.
     */
    public function __construct($validator)
    {
        $this->validator = $validator;
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
        $entityTagRegEx = '{^' . Rfc7232::ENTITY_TAG . '$}';
        if (utf8_decode($value) === $value && preg_match($entityTagRegEx, $value) === 1) {
            return new self(EntityTag::fromString($value));
        }

        $dateRegEx = '{^' . Rfc7231::HTTP_DATE . '$}';
        if (utf8_decode($value) === $value && preg_match($dateRegEx, $value) === 1) {
            return new self(Date::fromString($value, /*isWeak*/false));
        }

        throw new InvalidHeader('Invalid header value: ' . $value);
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
    public function isValid(): bool
    {
        return !$this->validator->isWeak();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'If-Range';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        if ($this->validator->isWeak()) {
            throw new InvalidHeader('Validator must be strong.');
        }

        return (string)$this->validator;
    }

    /**
     * @param EntityTag|Date|null $validator Validator. Should be a strong entity tag or date, or null if unknown.
     * @return bool Whether the condition is satisfied by the validator.
     */
    public function evaluate($validator): bool
    {
        if ($validator instanceof EntityTag && $this->validator instanceof EntityTag) {
            // Entity tags must be strong.
            return $this->validator->compareStrongly($validator);
        }

        if ($validator instanceof Date && $this->validator instanceof Date) {
            // Dates must be strong and match exactly.
            return !$validator->isWeak() && !$this->validator->isWeak() && $this->validator->isEq($validator);
        }

        return false;
    }

    /**
     * @return EntityTag|Date Strong validator.
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set validator.
     *
     * @param EntityTag|Date $validator Strong validator.
     */
    public function setValidator($validator): void
    {
        $this->validator = $validator;
    }
}
