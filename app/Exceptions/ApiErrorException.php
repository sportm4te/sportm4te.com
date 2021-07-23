<?php

namespace App\Exceptions;

abstract class ApiErrorException extends \Exception implements ExceptionInterface
{
    protected $type = 'api_error';
    protected $param;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setParam($param): self
    {
        $this->param = $param;

        return $this;
    }

    public function getParam(): ?string
    {
        return $this->param;
    }

    public function toArray(): ?array
    {
        return [
            'error' => [
                'message' => $this->getMessage(),
                'type'    => $this->getType(),
                'code'    => $this->getCode(),
                'param'   => $this->getParam(),
            ]
        ];
    }
}
