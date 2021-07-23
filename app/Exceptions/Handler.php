<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Exceptions;

use App\Exceptions\ApiConnectionException;
use App\Exceptions\ApiErrorException;
use App\Exceptions\ApiRateLimitException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Throwable $e)
    {
        $ex = $e;

        if ($request->routeIs('api.*')) {
            if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
                $e = new InvalidApiTokenException();
            } elseif ($e instanceof ThrottleRequestsException) {
                $e = new ApiRateLimitException();
            } elseif (!($e instanceof ApiErrorException)) {
                $e = new ApiConnectionException();
            }

            $response = $e->toArray();

            // If the app is in debug mode
            if (config('app.debug')) {
                // Add the exception class name, message and stack trace to response
                $response['debug']['exception'] = get_class($ex); // Reflection might be better here
                $response['debug']['message'] = $ex->getMessage();
                $response['debug']['trace'] = $ex->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            if ($this->isHttpException($e)) {
                // Grab the HTTP status code from the Exception
                $status = $e->getStatusCode();
            }

            // Return a JSON response with the response array and status code
            return response()->json($response, $status, [], JSON_PRETTY_PRINT);
        }

        $e = $this->prepareException($this->mapException($e));

        foreach ($this->renderCallbacks as $renderCallback) {
            if (is_a($e, $this->firstClosureParameterType($renderCallback))) {
                $response = $renderCallback($e, $request);

                if (!is_null($response)) {
                    return $response;
                }
            }
        }

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson()
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
