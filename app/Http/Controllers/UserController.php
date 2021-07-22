<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers;

use App\Management\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->response = $apiResponse;
    }

    public function me(Request $request)
    {
        if ($request->user()->guest()) {
            return $this->response->error();
        }

        return $request->user()->toArray();
    }
}
