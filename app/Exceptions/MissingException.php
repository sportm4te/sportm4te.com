<?php

namespace App\Exceptions;

class MissingException extends InvalidRequestException
{
    protected $message = 'The resource is missing.';

    protected $code = 'missing';
}
