<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'min:5', 'max:20', 'check_username', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthdate' => ['required', 'date', 'check_age'],
            'gender' => ['required', Rule::in(array_keys(User::GENDERS))],
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
