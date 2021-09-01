<?php

declare(strict_types=1);

namespace Stadly\Http\Utilities;

/**
 * Regular expressions for matching rules in RFC 7232:
 * Hypertext Transfer Protocol (HTTP/1.1): Conditional Requests
 *
 * Specification: https://tools.ietf.org/html/rfc7232
 */
final class Rfc7232
{
    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (ETag)
     */
    public const ETAG = self::ENTITY_TAG;

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (entity-tag)
     */
    public const ENTITY_TAG = '(?:' . self::WEAK . '?' . self::OPAQUE_TAG . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (entity-tag)
     */
    public const ENTITY_TAG_CAPTURE = '(?<ENTITY_TAG>' . self::WEAK_CAPTURE . '?' . self::OPAQUE_TAG_CAPTURE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (weak)
     */
    public const WEAK = '(?:W/)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (weak)
     */
    public const WEAK_CAPTURE = '(?<WEAK>W/)';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (opaque-tag)
     */
    public const OPAQUE_TAG = '(?:' . Rfc5234::DQUOTE . self::ETAGC . '*' . Rfc5234::DQUOTE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (opaque-tag)
     */
    public const OPAQUE_TAG_CAPTURE
        = '(?:' . Rfc5234::DQUOTE . '(?<ETAGCS>' . self::ETAGC . '*)' . Rfc5234::DQUOTE . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-2.3 (etagc)
     */
    public const ETAGC = "(?:[\x21\x23-\x7E]|" . Rfc7230::OBS_TEXT . ')';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-3.1 (If-Match)
     * Same as: "*" | Rfc7230::hashRule(self::ENTITY_TAG, 1)
     */
    public const IF_MATCH
        = '(?:\\*|(?:' . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*'
        . self::ENTITY_TAG . '(?:(?:' . Rfc7230::OWS . ',)+' . Rfc7230::OWS . self::ENTITY_TAG . ')*'
        . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-3.2 (If-None-Match)
     * Same as: "*" | Rfc7230::hashRule(self::ENTITY_TAG, 1)
     */
    public const IF_NONE_MATCH
        = '(?:\\*|(?:' . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*'
        . self::ENTITY_TAG . '(?:(?:' . Rfc7230::OWS . ',)+' . Rfc7230::OWS . self::ENTITY_TAG . ')*'
        . Rfc7230::OWS . '(?:,' . Rfc7230::OWS . ')*))';

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-3.4 (If-Modified-Since)
     */
    public const IF_MODIFIED_SINCE = Rfc7231::HTTP_DATE;

    /**
     * Specification: https://tools.ietf.org/html/rfc7232#section-3.4 (If-Unmodified-Since)
     */
    public const IF_UNMODIFIED_SINCE = Rfc7231::HTTP_DATE;
}
