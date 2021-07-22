<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

use App\Models\User\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'category' => 'required',
            'level' => ['required', Rule::in(array_keys(Event::LEVELS))],
            'location' => 'required|string|max:200',
            'place_id' => 'required|exists:place,id',
            'description' => 'required|string|max:1000',
            'start' => 'required|date',
            'start_at' => 'required|date_format:H:i',
            'end' => 'required|date',
            'end_at' => 'required|date_format:H:i',
            'deadline' => 'nullable|date|after:' . Carbon::today()->addDay()->toDateString(),
            'registration_limit' => 'nullable|numeric|min:1|max:1000',
        ];
    }
}
