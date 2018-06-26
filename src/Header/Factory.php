<?php

declare(strict_types=1);

namespace Stadly\Http\Header;

use InvalidArgumentException;
use Stadly\Http\Utilities\Rfc7230;

use Stadly\Http\Header\Common\ContentType;
use Stadly\Http\Header\Common\Header;
use Stadly\Http\Header\Request\IfMatch;
use Stadly\Http\Header\Request\IfNoneMatch;
use Stadly\Http\Header\Response\ETag;
use Stadly\Http\Header\Value\EntityTag;
use Stadly\Http\Header\Value\EntityTagSet;
use Stadly\Http\Header\Value\MediaType;

/**
 * Class for generating HTTP header fields.
 */
final class Factory
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
            case 'content-type':
                return new ContentType(MediaType::fromString($matches['FIELD_VALUE']));
            case 'if-match':
                return new IfMatch(EntityTagSet::fromString($matches['FIELD_VALUE']));
            case 'if-none-match':
                return new IfNoneMatch(EntityTagSet::fromString($matches['FIELD_VALUE']));
            case 'etag':
                return new ETag(EntityTag::fromString($matches['FIELD_VALUE']));
            default:
                return new Header($matches['FIELD_NAME'], $matches['FIELD_VALUE']);
        }
    }
}
