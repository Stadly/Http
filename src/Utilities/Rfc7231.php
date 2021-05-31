<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7231:
 * Hypertext Transfer Protocol (HTTP/1.1): Semantics and Content
 *
 * Specification: https://tools.ietf.org/html/rfc7231
 */
final class Rfc7231
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (media-type)
     */
    public const MEDIA_TYPE
        = '(?:' . self::TYPE . '/' . self::SUBTYPE
        . '(?:' . Rfc7230::OWS . ';' . Rfc7230::OWS . self::PARAMETER . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (media-type)
     */
    public const MEDIA_TYPE_CAPTURE
        = '(?:' . self::TYPE_CAPTURE . '/' . self::SUBTYPE_CAPTURE
        . '(?<PARAMETERS>(?:' . Rfc7230::OWS . ';' . Rfc7230::OWS . self::PARAMETER . ')*))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (type)
     */
    public const TYPE = Rfc7230::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (type)
     */
    public const TYPE_CAPTURE = '(?<TYPE>' . Rfc7230::TOKEN . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (subtype)
     */
    public const SUBTYPE = Rfc7230::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (subtype)
     */
    public const SUBTYPE_CAPTURE = '(?<SUBTYPE>' . Rfc7230::TOKEN . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (parameter)
     */
    public const PARAMETER = '(?:' . Rfc7230::TOKEN . '=(?:' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . '))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.1 (parameter)
     */
    public const PARAMETER_CAPTURE
        = '(?<PARAMETER>(?<NAME>' . Rfc7230::TOKEN . ')='
        . '(?<VALUE>' . Rfc7230::TOKEN . '|' . Rfc7230::QUOTED_STRING . '))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.2 (charset)
     */
    public const CHARSET = Rfc7230::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-3.1.1.5 (Content-Type)
     */
    public const CONTENT_TYPE = self::MEDIA_TYPE;

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (HTTP-date)
     */
    public const HTTP_DATE = '(?:' . self::IMF_FIXDATE . '|' . self::OBS_DATE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (IMF-fixdate)
     */
    public const IMF_FIXDATE
        = '(?:' . self::DAY_NAME . ',' . Rfc5234::SP . self::DATE1
        . Rfc5234::SP . self::TIME_OF_DAY . Rfc5234::SP . self::GMT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (day-name)
     */
    public const DAY_NAME = '(?:Mon|Tue|Wed|Thu|Fri|Sat|Sun)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (date1)
     */
    public const DATE1 = '(?:' . self::DAY . Rfc5234::SP . self::MONTH . Rfc5234::SP . self::YEAR . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (day)
     */
    public const DAY = Rfc5234::DIGIT . '{2}';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (day)
     */
    public const DAY_CAPTURE = '(?<DAY>' . Rfc5234::DIGIT . '{2})';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (month)
     */
    public const MONTH = '(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (month)
     */
    public const MONTH_CAPTURE = '(?<MONTH>Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (year)
     */
    public const YEAR = Rfc5234::DIGIT . '{4}';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (GMT)
     */
    public const GMT = '(?:GMT)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (time-of-day)
     */
    public const TIME_OF_DAY = '(?:' . self::HOUR . ':' . self::MINUTE . ':' . self::SECOND . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (time-of-day)
     */
    public const TIME_OF_DAY_CAPTURE = '(?<TIME_OF_DAY>' . self::HOUR . ':' . self::MINUTE . ':' . self::SECOND . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (hour)
     */
    public const HOUR = Rfc5234::DIGIT . '{2}';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (minute)
     */
    public const MINUTE = Rfc5234::DIGIT . '{2}';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (second)
     */
    public const SECOND = Rfc5234::DIGIT . '{2}';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (obs-date)
     */
    public const OBS_DATE = '(?:' . self::RFC850_DATE . '|' . self::ASCTIME_DATE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (rfc850-date)
     */
    public const RFC850_DATE
        = '(?:' . self::DAY_NAME_L . ',' . Rfc5234::SP . self::DATE2
        . Rfc5234::SP . self::TIME_OF_DAY . Rfc5234::SP . self::GMT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (rfc850-date)
     */
    public const RFC850_DATE_CAPTURE = '(?:' . self::DAY_NAME_L . ',' . Rfc5234::SP . self::DATE2_CAPTURE
        . Rfc5234::SP . self::TIME_OF_DAY_CAPTURE . Rfc5234::SP . self::GMT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (date2)
     */
    public const DATE2 = '(?:' . self::DAY . '-' . self::MONTH . '-' . Rfc5234::DIGIT . '{2})';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (date2)
     */
    public const DATE2_CAPTURE
        = '(?:' . self::DAY_CAPTURE . '-' . self::MONTH_CAPTURE . '-(?<YEAR>' . Rfc5234::DIGIT . '{2}))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (day-name-l)
     */
    public const DAY_NAME_L = '(?:Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (asctime-date)
     */
    public const ASCTIME_DATE
        = '(?:' . self::DAY_NAME . Rfc5234::SP . self::DATE3
        . Rfc5234::SP . self::TIME_OF_DAY . Rfc5234::SP . self::YEAR . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.1 (date3)
     */
    public const DATE3
        = '(?:' . self::MONTH . Rfc5234::SP . '(?:' . Rfc5234::DIGIT . '{2}|' . Rfc5234::SP . Rfc5234::DIGIT . '))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7231#section-7.1.1.2 (Date)
     */
    public const DATE = self::HTTP_DATE;
}
