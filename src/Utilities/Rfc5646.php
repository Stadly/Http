<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 5646:
 * Tags for Identifying Languages
 *
 * https://tools.ietf.org/html/rfc5646
 */
final class Rfc5646
{
    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (Language-Tag)
     */
    public const LANGUAGE_TAG = '(?:'.self::LANGTAG.'|'.self::PRIVATEUSE.'|'.self::GRANDFATHERED.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (langtag)
     */
    public const LANGTAG
        = '(?:'.self::LANGUAGE.'(?:-'.self::SCRIPT.')?(?:-'.self::REGION.')?'
        . '(?:-'.self::VARIANT.')*(?:-'.self::EXTENSION.')*(?:-'.self::PRIVATEUSE.')?)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (language)
     */
    public const LANGUAGE
        = '(?:'.Rfc5234::ALPHA.'{2,3}(?:-'.self::EXTLANG.')?|'.Rfc5234::ALPHA.'{4}|'.Rfc5234::ALPHA.'{5,8})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (extlang)
     */
    public const EXTLANG = '(?:'.Rfc5234::ALPHA.'{3}(?:-'.Rfc5234::ALPHA.'{3}){,2})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (script)
     */
    public const SCRIPT = '(?:'.Rfc5234::ALPHA.'{4})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (region)
     */
    public const REGION = '(?:'.Rfc5234::ALPHA.'{2}|'.Rfc5234::DIGIT.'{3})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (variant)
     */
    public const VARIANT = '(?:'.self::ALPHANUM.'{5,8}|'.Rfc5234::DIGIT.self::ALPHANUM.'{3})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (extension)
     */
    public const EXTENSION = '(?:'.self::SINGLETON.'(?:-'.self::ALPHANUM.'{2,8})+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (singleton)
     */
    public const SINGLETON = '(?:'.Rfc5234::DIGIT.'|[A-WYZa-wyz])';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (privateuse)
     */
    public const PRIVATEUSE = '(?:x(?:-'.self::ALPHANUM.'{1,8})+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (grandfathered)
     */
    public const GRANDFATHERED = '(?:'.self::IRREGULAR.'|'.self::REGULAR.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (irregular)
     */
    public const IRREGULAR
        = '(?:en-GB-oed|i-ami|i-bnn|i-default|i-enochian|i-hak|i-klingon|i-lux|i-mingo|i-navajo|'
        . 'i-pwn|i-tao|i-tay|i-tsu|sgn-BE-FR|sgn-BE-NL|sgn-CH-DE)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (regular)
     */
    public const REGULAR = '(?:art-lojban|cel-gaulish|no-bok|no-nyn|zh-guoyu|zh-hakka|zh-min|zh-min-nan|zh-xiang)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5646#section-2.1 (alphanum)
     */
    public const ALPHANUM = '(?:'.Rfc5234::ALPHA.'|'.Rfc5234::DIGIT.')';
}
