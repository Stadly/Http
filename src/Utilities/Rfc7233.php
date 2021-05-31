<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7233:
 * Hypertext Transfer Protocol (HTTP/1.1): Range Requests
 *
 * Specification: https://tools.ietf.org/html/rfc7233
 */
final class Rfc7233
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2 (range-unit)
     */
    public const RANGE_UNIT = '(?:' . self::BYTES_UNIT . '|' . self::OTHER_RANGE_UNIT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (bytes-unit)
     */
    public const BYTES_UNIT = '(?:[Bb][Yy][Tt][Ee][Ss])';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-ranges-specifier)
     */
    public const BYTE_RANGES_SPECIFIER = '(?:' . self::BYTES_UNIT . '=' . self::BYTE_RANGE_SET . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-ranges-specifier)
     */
    public const BYTE_RANGES_SPECIFIER_CAPTURE = '(?:' . self::BYTES_UNIT . '=' . self::BYTE_RANGE_SET_CAPTURE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-range-set)
     */
    public const BYTE_RANGE_SET
        = '(?:(?:,' . Rfc7230::OWS . ')*'
        . '(?:' . self::BYTE_RANGE_SPEC . '|' . self::SUFFIX_BYTE_RANGE_SPEC . ')'
        . '(?:' . Rfc7230::OWS . ',(?:' . Rfc7230::OWS
        . '(?:' . self::BYTE_RANGE_SPEC . '|' . self::SUFFIX_BYTE_RANGE_SPEC . '))?)*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-range-set)
     */
    public const BYTE_RANGE_SET_CAPTURE
        = '(?<BYTE_RANGE_SET>(?:,' . Rfc7230::OWS . ')*'
        . '(?:' . self::BYTE_RANGE_SPEC . '|' . self::SUFFIX_BYTE_RANGE_SPEC . ')'
        . '(?:' . Rfc7230::OWS . ',(?:' . Rfc7230::OWS
        . '(?:' . self::BYTE_RANGE_SPEC . '|' . self::SUFFIX_BYTE_RANGE_SPEC . '))?)*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-range-spec)
     */
    public const BYTE_RANGE_SPEC = '(?:' . self::FIRST_BYTE_POS . '-' . self::LAST_BYTE_POS . '?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (byte-range-spec)
     */
    public const BYTE_RANGE_SPEC_CAPTURE
        = '(?:' . self::FIRST_BYTE_POS_CAPTURE . '-' . self::LAST_BYTE_POS_CAPTURE . '?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (first-byte-pos)
     */
    public const FIRST_BYTE_POS = '(?:' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (first-byte-pos)
     */
    public const FIRST_BYTE_POS_CAPTURE = '(?<FIRST_BYTE_POS>' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (last-byte-pos)
     */
    public const LAST_BYTE_POS = '(?:' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (last-byte-pos)
     */
    public const LAST_BYTE_POS_CAPTURE = '(?<LAST_BYTE_POS>' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (suffix-byte-range-spec)
     */
    public const SUFFIX_BYTE_RANGE_SPEC = '(?:-' . self::SUFFIX_LENGTH . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (suffix-byte-range-spec)
     */
    public const SUFFIX_BYTE_RANGE_SPEC_CAPTURE = '(?:-' . self::SUFFIX_LENGTH_CAPTURE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (suffix-length)
     */
    public const SUFFIX_LENGTH = '(?:' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (suffix-length)
     */
    public const SUFFIX_LENGTH_CAPTURE = '(?<SUFFIX_LENGTH>' . Rfc5234::DIGIT . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (other-range-unit)
     */
    public const OTHER_RANGE_UNIT = Rfc7230::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-2.1 (other-range-unit)
     */
    public const OTHER_RANGE_UNIT_CAPTURE = '(?<OTHER_RANGE_UNIT>' . Rfc7230::TOKEN . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-3.1 (Range)
     */
    public const RANGE = '(?:' . self::BYTE_RANGES_SPECIFIER . '|' . self::OTHER_RANGES_SPECIFIER . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-3.1 (other-ranges-specifier)
     */
    public const OTHER_RANGES_SPECIFIER = '(?:' . self::OTHER_RANGE_UNIT . '=' . self::OTHER_RANGE_SET . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-3.1 (other-ranges-specifier)
     */
    public const OTHER_RANGES_SPECIFIER_CAPTURE
        = '(?:' . self::OTHER_RANGE_UNIT_CAPTURE . '=' . self::OTHER_RANGE_SET_CAPTURE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-3.1 (other-range-set)
     */
    public const OTHER_RANGE_SET = '(?:' . Rfc5234::VCHAR . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7233#section-3.1 (other-range-set)
     */
    public const OTHER_RANGE_SET_CAPTURE = '(?<OTHER_RANGE_SET>' . Rfc5234::VCHAR . '+)';
}
