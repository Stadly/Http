<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Response;

use InvalidArgumentException;
use Stadly\Http\Header\Common\HeaderFactory as CommonHeaderFactory;
use Stadly\Http\Header\Value\EntityTag;
use Stadly\Http\Utilities\Rfc7230;

/**
 * Class for generating HTTP response header fields.
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
        if (utf8_decode($header) !== $header || 1 !== preg_match('{^'.Rfc7230::HEADER_FIELD.'$}', $header, $matches)) {
            throw new InvalidArgumentException("Invalid header field: $header");
        }

        switch (strtolower($matches['FIELD_NAME'])) {
            case 'etag':
                return new ETag(EntityTag::fromString($matches['FIELD_VALUE']));
            default:
                return CommonHeaderFactory::fromString($header);
        }
    }
}
