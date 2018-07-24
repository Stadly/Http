<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 6266:
 * Use of the Content-Disposition Header Field in the Hypertext Transfer Protocol (HTTP)
 *
 * https://tools.ietf.org/html/rfc6266
 */
final class Rfc6266
{
    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (content-disposition)
     */
    public const CONTENT_DISPOSITION = '(?:[Cc][Oo][Nn][Tt][Ee][Nn][Tt]-[Dd][Ii][Ss][Pp][Oo][Ss][Ii][Tt][Ii][Oo][Nn]'
        . Rfc5234::LWSP.':'.Rfc5234::LWSP.self::DISPOSITION_TYPE
        . '(?:'.Rfc5234::LWSP.';'.Rfc5234::LWSP.self::DISPOSITION_PARM.')*'.Rfc5234::LWSP.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (disposition-type)
     */
    public const DISPOSITION_TYPE = '(?:[Ii][Nn][Ll][Ii][Nn][Ee]|[Aa][Tt][Tt][Aa][Cc][Hh][Mm][Ee][Nn][Tt]|'
        . self::DISP_EXT_TYPE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (disp-ext-type)
     */
    public const DISP_EXT_TYPE = Rfc2616::TOKEN;

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (disposition-parm)
     */
    public const DISPOSITION_PARM = '(?:'.self::FILENAME_PARM.'|'.self::DISP_EXT_PARM.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (filename-parm)
     */
    public const FILENAME_PARM = '(?:[Ff][Ii][Ll][Ee][Nn][Aa][Mm][Ee]'.Rfc5234::LWSP.'='.Rfc5234::LWSP.Rfc2616::VALUE
        . '|[Ff][Ii][Ll][Ee][Nn][Aa][Mm][Ee]\\*'.Rfc5234::LWSP.'='.Rfc5234::LWSP.Rfc5987::EXT_VALUE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (disp-ext-parm)
     */
    public const DISP_EXT_PARM = '(?:'.Rfc2616::TOKEN.Rfc5234::LWSP.'='.Rfc5234::LWSP.Rfc2616::VALUE
        . '|'.self::EXT_TOKEN.Rfc5234::LWSP.'='.Rfc5234::LWSP.Rfc5987::EXT_VALUE.')';

    /**
     * Specification: https://tools.ietf.org/html/rfc6266#section-4.1 (ext-token)
     */
    public const EXT_TOKEN = '(?:'.Rfc2616::TOKEN.'\\*)';
}
