<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 8187:
 * Indicating Character Encoding and Language for HTTP Header Field Parameters
 *
 * Specification: https://tools.ietf.org/html/rfc8187
 */
final class Rfc8187
{
    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (ext-value)
     */
    public const EXT_VALUE = '(?:' . self::CHARSET . "'" . self::LANGUAGE . "?'" . self::VALUE_CHARS . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (charset)
     */
    public const CHARSET = '(?:[Uu][Tt][Ff]-8|' . self::MIME_CHARSET . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (mime-charset)
     */
    public const MIME_CHARSET = '(?:' . self::MIME_CHARSETC . '+)';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (mime-charsetc)
     */
    public const MIME_CHARSETC = '(?:' . Rfc5234::ALPHA . '|' . Rfc5234::DIGIT . '|[!#$%&+\\-\\^_`{}~])';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (language)
     */
    public const LANGUAGE = Rfc5646::LANGUAGE_TAG;

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (value-chars)
     */
    public const VALUE_CHARS = '(?:(?:' . self::PCT_ENCODED . '|' . self::ATTR_CHAR . ')*)';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (pct-encoded)
     */
    public const PCT_ENCODED = '(?:%' . Rfc5234::HEXDIG . '{2})';

    /**
     * Specification: https://tools.ietf.org/html/rfc8187#section-3.2.1 (attr-char)
     */
    public const ATTR_CHAR = '(?:' . Rfc5234::ALPHA . '|' . Rfc5234::DIGIT . '|[!#$&+\\-.\\^_`|~])';
}
