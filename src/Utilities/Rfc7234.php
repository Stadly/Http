<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7234:
 * Hypertext Transfer Protocol (HTTP/1.1): Caching
 *
 * https://tools.ietf.org/html/rfc7234
 */
abstract class Rfc7234
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7234#section-1.2.1 (delta-seconds)
     */
    public const DELTA_SECONDS = '(?:'.Rfc5234::DIGIT.'+)';
}
