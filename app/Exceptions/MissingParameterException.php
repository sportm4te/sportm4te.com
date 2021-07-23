<?php

namespace App\Exceptions;

class MissingParameterException extends InvalidRequestException
{
    protected $code = 'missing_parameter';
}
