<?php

namespace App\Exceptions;

class InvalidApiTokenException extends InvalidRequestException
{
    protected $code = 'invalid_token_key';

    protected $message = 'Entered API token is invalid.';

    protected $param = 'token';
}
