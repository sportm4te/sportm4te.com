<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class StoreSettingsRequest extends ApiRequest
{
    public function rules()
    {
        return [
            // 'name'   => 'required|string|min:2|max:100',
            'bio' => 'nullable|string|max:1000',
            // 'birthdate' => 'required|date',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user())],
            'unit' => ['required', Rule::in(array_keys(User::LENGTH_UNITS))],
            'gender' => [Rule::in(array_keys(User::GENDERS))],
            'timezone' => 'required|exists:timezone,id',
        ];
    }
}
