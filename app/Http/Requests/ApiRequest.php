<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\MissingParameterException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $failed = $validator->failed();

        foreach ($validator->errors()->messages() as $key => $error) {
            if (array_key_exists('Required', $failed[$key])) {
                $exception = new MissingParameterException($error[0]);
            } else {
                $exception = new InvalidParameterException($error[0]);
            }

            $exception->setParam($key);

            throw $exception;
        }
    }

    public function attributes()
    {
        return array_combine($this->request->keys(), $this->request->keys());
    }
}
