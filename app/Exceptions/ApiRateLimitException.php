<?php

namespace App\Exceptions;

class ApiRateLimitException extends InvalidRequestException
{
    protected $code = 'rate_limit_error';

    protected $message = 'Rate limit exceeded.';
}
