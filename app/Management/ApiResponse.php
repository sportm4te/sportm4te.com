<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Management;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function basicResponse($response)
    {
        return new JsonResponse($response);
    }

    public function success(array $response = [])
    {
        return new JsonResponse($response);
    }

    public function error(string $message = null)
    {
        return new JsonResponse([
            'success' => false,
            'errors' => $message,
        ], 400);
    }
}
