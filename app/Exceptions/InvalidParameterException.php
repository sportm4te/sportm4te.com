<?php

namespace App\Exceptions;

class InvalidParameterException extends InvalidRequestException
{
    protected $code = 'invalid_parameter';
}
