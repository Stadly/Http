<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7231:
 * Hypertext Transfer Protocol (HTTP/1.1): Semantics and Content
 *
 * https://tools.ietf.org/html/rfc7231
 */
abstract class Rfc7231
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (media-type)
     */
    public const MEDIA_TYPE = '(?:'.self::TYPE.'/'.self::SUBTYPE
        . '(?<PARAMETERS>(?:'.Rfc7230::OWS.';'.Rfc7230::OWS.self::PARAMETER.')*))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (type)
     */
    public const TYPE = '(?<TYPE>'.Rfc7230::TOKEN.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (subtype)
     */
    public const SUBTYPE = '(?<SUBTYPE>'.Rfc7230::TOKEN.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (parameter)
     */
    public const PARAMETER = '(?<PARAMETER>(?<NAME>'.Rfc7230::TOKEN.')='
        . '(?<VALUE>'.Rfc7230::TOKEN.'|'.Rfc7230::QUOTED_STRING.'))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.2 (charset)
     */
    public const CHARSET = Rfc7230::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.5 (Content-Type)
     */
    public const CONTENT_TYPE = self::MEDIA_TYPE;
}
