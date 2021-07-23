<?php

namespace App\Exceptions;

class InvalidRequestException extends ApiErrorException
{
    protected $type = 'invalid_request_error';
}
