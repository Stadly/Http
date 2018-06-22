<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use InvalidArgumentException;
use Throwable;

/**
 * Exception thrown when setting an invalid header field.
 */
final class InvalidFormat extends InvalidArgumentException
{
    /**
     * @var string Header field.
     */
    private $header;

    /**
     * Constructor.
     *
     * @param string $header Header field.
     * @param Throwable $Previous Previous exception, used for exception chaining.
     */
    public function __construct(string $header, ?Throwable $Previous = null)
    {
        $this->header = $header;
        
        parent::__construct("Invalid header field: $header", /*Code*/0, $Previous);
    }
    
    /**
     * @return string Header field format.
     */
    public function getHeader(): string
    {
        return $this->header;
    }
}
