<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 5987:
 * Character Set and Language Encoding for Hypertext Transfer Protocol (HTTP) Header Field Parameters
 *
 * https://tools.ietf.org/html/rfc5987
 */
abstract class Rfc5987
{
    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (parameter)
     */
    public const PARAMETER = '(?:'.self::REG_PARAMETER.'|'.self::EXT_PARAMETER.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (reg-parameter)
     */
    public const REG_PARAMETER = '(?:'.self::PARAMNAME.Rfc5234::LWSP.'='.Rfc5234::LWSP.Rfc2616::VALUE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (ext-parameter)
     */
    public const EXT_PARAMETER = '(?:'.self::PARAMNAME.'\\*'.Rfc5234::LWSP.'='.Rfc5234::LWSP.self::EXT_VALUE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (parmname)
     */
    public const PARAMNAME = '(?:'.self::ATTR_CHAR.'+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (ext-value)
     */
    public const EXT_VALUE = '(?:'.self::CHARSET."'".self::LANGUAGE."?'".self::VALUE_CHARS.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (charset)
     */
    public const CHARSET = '(?:[Uu][Tt][Ff]-8|[Ii][Ss][Oo]-8859-1|'.self::MIME_CHARSET.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (mime-charset)
     */
    public const MIME_CHARSET = '(?:'.self::MIME_CHARSETC.'+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (mime-charsetc)
     */
    public const MIME_CHARSETC = '(?:'.Rfc5234::ALPHA.'|'.Rfc5234::DIGIT.'|[!#$%&+\\-\\^_`{}~])';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (language)
     */
    public const LANGUAGE = Rfc5646::LANGUAGE_TAG;

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (value-chars)
     */
    public const VALUE_CHARS = '(?:(?:'.self::PCT_ENCODED.'|'.self::ATTR_CHAR.')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (pct-encoded)
     */
    public const PCT_ENCODED = '(?:%'.Rfc5234::HEXDIG.'{2})';

    /**
     * Specification: https://tools.ietf.org/html/rfc5987#section-3.2.1 (attr-char)
     */
    public const ATTR_CHAR = '(?:'.Rfc5234::ALPHA.'|'.Rfc5234::DIGIT.'|[!#$&+\\-.\\^_`|~])';
}
