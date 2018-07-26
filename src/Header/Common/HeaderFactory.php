<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
use Stadly\Http\Header\Value\MediaType\MediaType;
use Stadly\Http\Utilities\Rfc7230;

/**
 * Class for generating HTTP header fields.
 */
final class HeaderFactory
{
    /**
     * Construct header from string.
     *
     * @param string $header Header field string.
     * @return HeaderInterface Header generated based on the string.
     */
    public static function fromString(string $header): HeaderInterface
    {
        $regEx = '{^'.Rfc7230::HEADER_FIELD_CAPTURE.'$}';
        if (utf8_decode($header) !== $header || 1 !== preg_match($regEx, $header, $matches)) {
            throw new InvalidArgumentException("Invalid header field: $header");
        }

        switch (strtolower($matches['FIELD_NAME'])) {
            case 'content-type':
                return new ContentType(MediaType::fromString($matches['FIELD_VALUE']));
            default:
                return new Header($matches['FIELD_NAME'], $matches['FIELD_VALUE']);
        }
    }
}
