<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use Stadly\Http\Header\Request\HeaderInterface as RequestHeaderInterface;
use Stadly\Http\Header\Response\HeaderInterface as ResponseHeaderInterface;

interface HeaderInterface extends ResponseHeaderInterface, RequestHeaderInterface
{
}
