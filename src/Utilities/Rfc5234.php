<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 5234:
 * Augmented BNF for Syntax Specifications: ABNF
 *
 * https://tools.ietf.org/html/rfc5234
 */
final class Rfc5234
{
    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (ALPHA)
     */
    public const ALPHA = '[A-Za-z]';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (BIT)
     */
    public const BIT = '[01]';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (CHAR)
     */
    public const CHAR = "[\x01-\x7F]";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (CR)
     */
    public const CR = "\x0D";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (CRLF)
     */
    public const CRLF = '(?:'.self::CR.self::LF.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (CTL)
     */
    public const CTL = "[\x00-\x1F\x7F]";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (DIGIT)
     */
    public const DIGIT = '[0-9]';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (DQUOTE)
     */
    public const DQUOTE = "\x22";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (HEXDIG)
     */
    public const HEXDIG = '(?:'.self::DIGIT.'|[A-Fa-f])';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (HTAB)
     */
    public const HTAB = "\x09";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (LF)
     */
    public const LF = "\x0A";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (LWSP)
     */
    public const LWSP = '(?:(?:'.self::WSP.'|'.self::CRLF.self::WSP.')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (OCTET)
     */
    public const OCTET = "[\x00-\xFF]";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (SP)
     */
    public const SP = "\x20";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (VCHAR)
     */
    public const VCHAR = "[\x21-\x7E]";

    /**
     * Specification: https://tools.ietf.org/html/rfc5234#appendix-B.1 (WSP)
     */
    public const WSP = '(?:'.self::SP.'|'.self::HTAB.')';
}
