<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use InvalidArgumentException;
use Throwable;

/**
 * Exception thrown when setting an invalid header field value.
 */
final class InvalidValue extends InvalidArgumentException
{
    /**
     * @var string Header field value.
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $value Header field value.
     * @param Throwable $Previous Previous exception, used for exception chaining.
     */
    public function __construct(string $value, ?Throwable $Previous = null)
    {
        $this->value = $value;
        
        parent::__construct("Invalid header field value: $value", /*Code*/0, $Previous);
    }
    
    /**
     * @return string Header field value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
