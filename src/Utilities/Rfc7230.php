<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7230:
 * Hypertext Transfer Protocol (HTTP/1.1): Message Syntax and Routing
 *
 * https://tools.ietf.org/html/rfc7230
 */
abstract class Rfc7230
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (header-field)
     */
    public const HEADER_FIELD = '(?<HEADER_FIELD>'.self::FIELD_NAME.':'.self::OWS.self::FIELD_VALUE.self::OWS.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-name)
     */
    public const FIELD_NAME = '(?<FIELD_NAME>'.self::TOKEN.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-value)
     */
    public const FIELD_VALUE = '(?<FIELD_VALUE>(?:'.self::FIELD_CONTENT.'|'.self::OBS_FOLD.')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-content)
     *
     * This rule has been updated by an erratum: https://www.rfc-editor.org/errata/eid4189
     * Original: field-vchar [ 1*( SP / HTAB ) field-vchar ]
     * Updated: field-vchar [ 1*( SP / HTAB / field-vchar ) field-vchar ]
     */
    public const FIELD_CONTENT = '(?:'.self::FIELD_VCHAR
        . '(?:(?:'.Rfc5234::SP.'|'.Rfc5234::HTAB.'|'.self::FIELD_VCHAR.')+'.self::FIELD_VCHAR.')?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-vchar)
     */
    public const FIELD_VCHAR = '(?:'.Rfc5234::VCHAR.'|'.self::OBS_TEXT.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (obs-fold)
     *
     * This rule has been updated by an erratum: https://www.rfc-editor.org/errata/eid4189
     * Original: CRLF 1*( SP / HTAB )
     * Updated: OWS CRLF 1*( SP / HTAB )
     */
    public const OBS_FOLD = '(?:'.self::OWS.Rfc5234::CRLF.'(?:'.Rfc5234::SP.'|'.Rfc5234::HTAB.')+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (OWS)
     */
    public const OWS = '(?:(?:'.Rfc5234::SP.'|'.Rfc5234::HTAB.')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (RWS)
     */
    public const RWS = '(?:(?:'.Rfc5234::SP.'|'.Rfc5234::HTAB.')+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (BWS)
     */
    public const BWS = self::OWS;

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (token)
     */
    public const TOKEN = '(?:'.self::TCHAR.'+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (tchar)
     */
    public const TCHAR = "(?:[!#$%&'*+\\-.\\^_`|~]|".Rfc5234::DIGIT.'|'.Rfc5234::ALPHA.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (quoted-string)
     */
    public const QUOTED_STRING = '(?:'.Rfc5234::DQUOTE
        . '(?:'.self::QDTEXT.'|'.self::QUOTED_PAIR.')*'.Rfc5234::DQUOTE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (qdtext)
     */
    public const QDTEXT = '(?:'.Rfc5234::HTAB.'|'.Rfc5234::SP."|[\x21\x23-\x5B\\\x5D-\x7E]|".self::OBS_TEXT.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (obs-text)
     */
    public const OBS_TEXT = "[\x80-\xFF]";

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (comment)
     */
    public const COMMENT = '(?:\\((?:'.self::CTEXT.'|'.self::QUOTED_PAIR.'|(?R))*\\))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (ctext)
     */
    public const CTEXT = '(?:'.Rfc5234::HTAB.'|'.Rfc5234::SP.'|[\x21-\x27\x2A-\x5B\x5D-\x7E]|'.self::OBS_TEXT.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (quoted-pair)
     */
    public const QUOTED_PAIR = '(?:\\\\(?:'.Rfc5234::HTAB.'|'.Rfc5234::SP.'|'.Rfc5234::VCHAR.'|'.self::OBS_TEXT.'))';
}
