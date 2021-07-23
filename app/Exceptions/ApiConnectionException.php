<?php

namespace App\Exceptions;

class ApiConnectionException extends ApiErrorException
{
    protected $message = 'Unexpected internal error has occurred.';

    protected $code = 'internal';
}
