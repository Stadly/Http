<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Request;

use InvalidArgumentException;
use Stadly\Http\Header\Common\HeaderFactory as CommonHeaderFactory;
use Stadly\Http\Header\Value\EntityTag\EntityTagSet;
use Stadly\Http\Header\Value\Range\RangeSetFactory;
use Stadly\Http\Utilities\Rfc7230;

/**
 * Class for generating HTTP request header fields.
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
            case 'if-match':
                return new IfMatch(EntityTagSet::fromString($matches['FIELD_VALUE']));
            case 'if-none-match':
                return new IfNoneMatch(EntityTagSet::fromString($matches['FIELD_VALUE']));
            case 'range':
                return new Range(RangeSetFactory::fromString($matches['FIELD_VALUE']));
            default:
                return CommonHeaderFactory::fromString($header);
        }
    }
}
