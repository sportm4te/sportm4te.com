<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

class ReviewRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'rating' => ['required', 'numeric', 'max:5'],
            'review' => ['string', 'max:1500'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
