<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // https://stackoverflow.com/a/51065582/16443811
    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            return $this->handleApiException($request, $e);
        } else {
            $retval = parent::render($request, $e);
        }

        return $retval;
    }

    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'unauthenticated';
                break;
            case 403:
                $response['message'] = 'forbidden';
                break;
            case 404:
                $response['message'] = 'resource:not:found';
                break;
            case 405:
                $response['message'] = 'method:not:allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'something:went:wrong' : $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            if(method_exists($exception, 'getTrace')) {
                $response['errors']['trace'] = $exception->getTrace();
            } else if (method_exists($exception, 'getCode')) {
                $response['errors']['code'] = $exception->getCode();
            } else if (method_exists($exception, 'getMessage')) {
                $response['errors']['message'] = $exception->getMessage();
            }
        }

        $response['code'] = $statusCode;

        return response()->json($response, $statusCode);
    }
}
