<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class StoreScoreRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'score' => 'required|numeric',
        ];
    }
}

