<?php

declare(strict_types=1);

namespace App\Exceptions;

use MyParcelCom\Integration\Exceptions\Handler;

class ExceptionHandler extends Handler
{
    protected $dontReport = [
        RequestUnauthorizedException::class
    ];
}
