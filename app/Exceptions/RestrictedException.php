<?php

namespace App\Exceptions;

class RestrictedException extends InvalidRequestException
{
    protected $message = 'Access to this resource is restricted.';

    protected $code = 'restricted';
}
