<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7234:
 * Hypertext Transfer Protocol (HTTP/1.1): Caching
 *
 * Specification: https://tools.ietf.org/html/rfc7234
 */
final class Rfc7234
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7234#section-1.2.1 (delta-seconds)
     */
    public const DELTA_SECONDS = '(?:' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://datatracker.ietf.org/doc/html/rfc7234#section-5.2 (Cache-Control)
     * Same as: Rfc7230::hashRule(self::CACHE_DIRECTIVE, 1)
     */
    public const CACHE_CONTROL
        = '(?:' . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*'
        . self::CACHE_DIRECTIVE . '(?:(?:' . Rfc7230::OWS . ',)+' . Rfc7230::OWS . self::CACHE_DIRECTIVE . ')*'
        . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7234#section-5.2 (cache-directive)
     */
    public const CACHE_DIRECTIVE
        = '(?:' . Rfc7230::TOKEN . '(?:=(?:' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . '))?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7234#section-5.2 (cache-directive)
     */
    public const CACHE_DIRECTIVE_CAPTURE
        = '(?<CACHE_DIRECTIVE>(?<NAME>' . Rfc7230::TOKEN . ')(?:='
        . '(?<VALUE>' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . '))?)';
}
