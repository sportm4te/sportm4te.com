<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

class LoginRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email'    => 'required|string',
            'password' => 'required|string',
        ];
    }
}
