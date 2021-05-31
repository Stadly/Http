<?php

declare(strict_types=1);

namespace Stadly\Http\Header\Common;

use Stadly\Http\Header\Request\Header as RequestHeader;
use Stadly\Http\Header\Response\Header as ResponseHeader;

interface Header extends ResponseHeader, RequestHeader
{
}
