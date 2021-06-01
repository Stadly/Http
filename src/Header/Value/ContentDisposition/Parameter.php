<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Value\ContentDisposition;

use Stadly\Http\Utilities\Rfc6266;

/**
 * Class for handling content disposition parameters.
 *
 * Specification: https://tools.ietf.org/html/rfc6266#section-4.1
 */
abstract class Parameter
{
    /**
     * @var string Name.
     */
    protected $name;

    /**
     * @var string Value.
     */
    protected $value;

    /**
     * Construct parameter from string.
     *
     * @param string $parameter Parameter string.
     * @return self Parameter generated based on the string.
     */
    public static function fromString(string $parameter): self
    {
        $regEx = '{^' . Rfc6266::DISPOSITION_PARM_EXTENDED . '$}';
        if (preg_match($regEx, $parameter) === 1) {
            return ExtendedParameter::fromString($parameter);
        }

        return RegularParameter::fromString($parameter);
    }

    /**
     * @return string String representation of the parameter.
     */
    abstract public function __toString(): string;

    /**
     * @return string Name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name Name.
     */
    abstract public function setName(string $name): void;

    /**
     * @return string Value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value Value.
     */
    abstract public function setValue(string $value): void;
}
