<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use InvalidArgumentException;
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
     * @return Header Header generated based on the string.
     */
    public static function fromString(string $header): Header
    {
        $regEx = '{^' . Rfc7230::HEADER_FIELD_CAPTURE . '$}';
        if (utf8_decode($header) !== $header || preg_match($regEx, $header, $matches) !== 1) {
            throw new InvalidArgumentException('Invalid header field: ' . $header);
        }

        switch (strtolower($matches['FIELD_NAME'])) {
            case 'content-type':
                return ContentType::fromValue($matches['FIELD_VALUE']);
            default:
                return new ArbitraryHeader($matches['FIELD_NAME'], $matches['FIELD_VALUE']);
        }
    }
}
