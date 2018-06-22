<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Exception;

use InvalidArgumentException;
use Throwable;

/**
 * Exception thrown when setting an invalid header field name.
 */
final class InvalidName extends InvalidArgumentException
{
    /**
     * @var string Header field name.
     */
    private $name;

    /**
     * Constructor.
     *
     * @param string $name Header field name.
     * @param Throwable $Previous Previous exception, used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $Previous = null)
    {
        $this->name = $name;
        
        parent::__construct("Invalid header field name: $name", /*Code*/0, $Previous);
    }
    
    /**
     * @return string Header field name.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
