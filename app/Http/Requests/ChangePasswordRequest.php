<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Requests;


use App\Http\Requests\ApiRequest;

class ChangePasswordRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
