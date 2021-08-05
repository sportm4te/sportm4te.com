<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class ProviderRegisterRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'min:4', 'max:20', 'check_username', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthdate' => ['required', 'date_format:Y-m-d', 'check_age'],
            'gender' => [Rule::in(array_keys(User::GENDERS))],
            'terms' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'check_age' => 'You are not able to join.',
        ];
    }
}
