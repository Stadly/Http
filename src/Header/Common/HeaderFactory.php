<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use Stadly\Http\Exception\InvalidHeader;
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
     * @throws InvalidHeader If the header is invalid.
     */
    public static function fromString(string $header): Header
    {
        $regEx = '{^' . Rfc7230::HEADER_FIELD_CAPTURE . '$}';
        $plainHeader = mb_convert_encoding($header, 'ISO-8859-1', 'UTF-8');
        if ($plainHeader !== $header || preg_match($regEx, $header, $matches) !== 1) {
            throw new InvalidHeader('Invalid header field: ' . $header);
        }

        switch (strtolower($matches['FIELD_NAME'])) {
            case 'content-type':
                return ContentType::fromValue($matches['FIELD_VALUE']);
            default:
                return new ArbitraryHeader($matches['FIELD_NAME'], $matches['FIELD_VALUE']);
        }
    }
}
