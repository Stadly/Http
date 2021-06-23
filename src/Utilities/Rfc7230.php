<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

use InvalidArgumentException;

/**
 * Regular expressions for matching rules in RFC 7230:
 * Hypertext Transfer Protocol (HTTP/1.1): Message Syntax and Routing
 *
 * Specification: https://tools.ietf.org/html/rfc7230
 */
final class Rfc7230
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (header-field)
     */
    public const HEADER_FIELD = '(?:' . self::FIELD_NAME . ':' . self::OWS . self::FIELD_VALUE . self::OWS . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (header-field)
     */
    public const HEADER_FIELD_CAPTURE
        = '(?:' . self::FIELD_NAME_CAPTURE . ':' . self::OWS . self::FIELD_VALUE_CAPTURE . self::OWS . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-name)
     */
    public const FIELD_NAME = self::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-name)
     */
    public const FIELD_NAME_CAPTURE = '(?<FIELD_NAME>' . self::TOKEN . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-value)
     */
    public const FIELD_VALUE = '(?:(?:' . self::FIELD_CONTENT . '|' . self::OBS_FOLD . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-value)
     */
    public const FIELD_VALUE_CAPTURE = '(?<FIELD_VALUE>(?:' . self::FIELD_CONTENT . '|' . self::OBS_FOLD . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-content)
     *
     * This rule has been updated by an erratum: https://www.rfc-editor.org/errata/eid4189
     * Original: field-vchar [ 1*( SP / HTAB ) field-vchar ]
     * Updated: field-vchar [ 1*( SP / HTAB / field-vchar ) field-vchar ]
     */
    public const FIELD_CONTENT
        = '(?:' . self::FIELD_VCHAR
        . '(?:(?:' . Rfc5234::SP . '|' . Rfc5234::HTAB . '|' . self::FIELD_VCHAR . ')+' . self::FIELD_VCHAR . ')?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (field-vchar)
     */
    public const FIELD_VCHAR = '(?:' . Rfc5234::VCHAR . '|' . self::OBS_TEXT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2 (obs-fold)
     *
     * This rule has been updated by an erratum: https://www.rfc-editor.org/errata/eid4189
     * Original: CRLF 1*( SP / HTAB )
     * Updated: OWS CRLF 1*( SP / HTAB )
     */
    public const OBS_FOLD = '(?:' . self::OWS . Rfc5234::CRLF . '(?:' . Rfc5234::SP . '|' . Rfc5234::HTAB . ')+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (OWS)
     */
    public const OWS = '(?:(?:' . Rfc5234::SP . '|' . Rfc5234::HTAB . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (RWS)
     */
    public const RWS = '(?:(?:' . Rfc5234::SP . '|' . Rfc5234::HTAB . ')+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.3 (BWS)
     */
    public const BWS = self::OWS;

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (token)
     */
    public const TOKEN = '(?:' . self::TCHAR . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (tchar)
     */
    public const TCHAR = "(?:[!#$%&'*+\\-.\\^_`|~]|" . Rfc5234::DIGIT . '|' . Rfc5234::ALPHA . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (quoted-string)
     */
    public const QUOTED_STRING
        = '(?:' . Rfc5234::DQUOTE . '(?:' . self::QDTEXT . '|' . self::QUOTED_PAIR . ')*' . Rfc5234::DQUOTE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (qdtext)
     */
    public const QDTEXT
        = '(?:' . Rfc5234::HTAB . '|' . Rfc5234::SP . "|[\x21\x23-\x5B\\\x5D-\x7E]|" . self::OBS_TEXT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (obs-text)
     */
    public const OBS_TEXT = "[\x80-\xFF]";

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (comment)
     */
    public const COMMENT = '(?:\\((?:' . self::CTEXT . '|' . self::QUOTED_PAIR . '|(?R))*\\))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (ctext)
     */
    public const CTEXT
        = '(?:' . Rfc5234::HTAB . '|' . Rfc5234::SP . '|[\x21-\x27\x2A-\x5B\x5D-\x7E]|' . self::OBS_TEXT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-3.2.6 (quoted-pair)
     */
    public const QUOTED_PAIR
        = '(?:\\\\(?:' . Rfc5234::HTAB . '|' . Rfc5234::SP . '|' . Rfc5234::VCHAR . '|' . self::OBS_TEXT . '))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7230#section-7 (#rule)
     *
     * This function produces the following rules:
     * 0# element => [ ( *( "," OWS ) element *((OWS ",")+ OWS element ) | ",") *( OWS ",") ]
     * x# element => *( "," OWS ) element <x-1>*((OWS ",")+ OWS element ) *( OWS ",")
     *
     * 0#0 element => [ "," *( OWS ",") ]
     * 0#1 element => [ ( *( "," OWS ) element | "," ) *( OWS ",") ]
     * 0#y element => [ ( *( "," OWS ) element *<y-1>((OWS ",")+ OWS element ) | "," ) *( OWS ",") ]
     *
     * 1#1 element => *( "," OWS ) element *( OWS ",")
     * x#y element => *( "," OWS ) element <x-1>*<y-1>((OWS ",")+ OWS element ) *( OWS ",")
     *
     * @param string $element Regular expression for the list element.
     * @param int $min Minimum number of elements in list.
     * @param int|null $max Maximum number of elements in list.
     * @return string Regular expression for the list.
     */
    public static function hashRule(string $element, int $min = 0, ?int $max = null): string
    {
        if ($min < 0) {
            throw new InvalidArgumentException('Min number of elements must be non-negative.');
        }
        if ($max !== null && $min > $max) {
            throw new InvalidArgumentException('Max number of elements must be greater than or equal to min.');
        }

        if ($max === 0) {
            $regEx = ',';
        } else {
            $regEx = '(?:,' . self::OWS . ')*' . $element;

            if ($max !== 1) {
                $minRepeat = max(0, $min - 1);
                $maxRepeat = $max === null ? '' : $max - 1;

                $regEx
                    .= '(?:(?:' . self::OWS . ',)+' . self::OWS . $element . '){' . $minRepeat . ',' . $maxRepeat . '}';
            }

            if ($min === 0) {
                $regEx = '(?:' . $regEx . '|,)';
            }
        }

        $regEx .= '(?:' . self::OWS . ',)*';

        if ($min === 0) {
            $regEx = '(?:' . $regEx . ')?';
        }

        return $regEx;
    }
}
