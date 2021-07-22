<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'members' => 'array|required|min:1',
        ];
    }
}
