<?php

declare(strict_types=1);

namespace Stadly\Http\Header;

interface HeaderInterface
{
    /**
     * @return string String representation of the header field.
     */
    public function __toString(): string;

    /**
     * @return string Header field name.
     */
    public function getName(): string;

    /**
     * @return string Header field value.
     */
    public function getValue(): string;
}
