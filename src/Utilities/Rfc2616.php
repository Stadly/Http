<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 2616:
 * Hypertext Transfer Protocol -- HTTP/1.1
 *
 * https://tools.ietf.org/html/rfc2616
 */
abstract class Rfc2616
{
    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (OCTET)
     */
    public const OCTET = "[\x00-\xFF]";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (CHAR)
     */
    public const CHAR = "[\x00-\x7F]";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (UPALPHA)
     */
    public const UPALPHA = '[A-Z]';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (LOALPHA)
     */
    public const LOALPHA = '[a-z]';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (ALPHA)
     */
    public const ALPHA = '(?:'.self::UPALPHA.'|'.self::LOALPHA.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (DIGIT)
     */
    public const DIGIT = '[0-9]';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (CTL)
     */
    public const CTL = "[\x00-\x1F\x7F]";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (CR)
     */
    public const CR = "\x0D";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (LF)
     */
    public const LF = "\x0A";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (SP)
     */
    public const SP = "\x20";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (HT)
     */
    public const HT = "\x09";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (<">)
     */
    public const DQUOTE = "\x22";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (CRLF)
     */
    public const CRLF = '(?:'.self::CR.self::LF.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (LWS)
     */
    public const LWS = '(?:'.self::CRLF.'?(?:'.self::SP.'|'.self::HT.')+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (TEXT)
     */
    public const TEXT = "(?:[\x20-\x7E]|".self::LWS.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (HEX)
     */
    public const HEX = '(?:'.self::DIGIT.'|[A-Fa-f])';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (token)
     */
    public const TOKEN = "(?:[!#-'*+\\-.0-9A-Z\\^-z|~]+)";

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (separators)
     */
    public const SEPARATORS = '(?:[()<>@,;:\\\\"/[\\]?={}]|'.self::SP.'|'.self::HT.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (comment)
     */
    public const COMMENT = '(?:\\((?:'.self::CTEXT.'|'.self::QUOTED_PAIR.'|(?R))*\\))';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (ctext)
     */
    public const CTEXT = "(?:[\x20-\x27\x2A-\x7E]|".self::LWS.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (quoted-string)
     */
    public const QUOTED_STRING = '(?:'.self::DQUOTE.'(?:'.self::QDTEXT.'|'.self::QUOTED_PAIR.')*'.self::DQUOTE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (qdtext)
     */
    public const QDTEXT = "(?:[\x20\x21\x23-\x7E]|".self::LWS.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-2.2 (quoted-pair)
     */
    public const QUOTED_PAIR = '(?:\\\\[\x00-\x7F])';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-3.6 (transfer-coding)
     */
    public const TRANSFER_CODING = '(?:[Cc][Hh][Uu][Nn][Kk][Ee][Dd]|'.self::TRANSFER_EXTENSION.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-3.6 (transfer-extension)
     */
    public const TRANSFER_EXTENSION = '(?:'.self::TOKEN.'(?:'.self::LWS.'*;'.self::LWS.'*'.self::PARAMETER.')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-3.6 (parameter)
     */
    public const PARAMETER = '(?:'.self::ATTRIBUTE.self::LWS.'*='.self::LWS.'*'.self::VALUE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-3.6 (attribute)
     */
    public const ATTRIBUTE = self::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc2616#section-3.6 (value)
     */
    public const VALUE = '(?:'.self::TOKEN.'|'.self::QUOTED_STRING.')';
}
