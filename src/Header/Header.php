<?php

declare(strict_types=1);

namespace Stadly\Http\Header;

use RuntimeException;

interface Header
{
    /**
     * @return string String representation of the header field.
     * @throws RuntimeException If the header is invalid.
     */
    public function __toString(): string;

    /**
     * @return string Header field name.
     */
    public function getName(): string;

    /**
     * @return string Header field value.
     * @throws RuntimeException If the header is invalid.
     */
    public function getValue(): string;
}
