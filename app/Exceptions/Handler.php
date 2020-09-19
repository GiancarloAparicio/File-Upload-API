<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return response()->json([
                'errors' => [
                    [
                        'status' => strtolower(404),
                        'title' => 'Model error'  . $model,
                        'details' => $exception->getMessage()
                    ]
                ]
            ], 404);
        }

        if ($exception instanceof QueryException) {
            return response()->json([
                'errors' => [
                    [
                        'status' => strtolower(500),
                        'title' => 'BD query error ',
                        'details' => $exception->getMessage()
                    ]
                ]
            ], 500);
        }

        if ($exception instanceof HttpException) {
            return response()->json([
                'errors' => [
                    [
                        'status' => strtolower($exception->getStatusCode()),
                        'title' => 'Path error, not found ',
                        'details' => $exception->getMessage()
                    ]
                ]
            ], $exception->getStatusCode());
        }


        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => [
                    [
                        'status' => strtolower($exception->status),
                        'title' => 'Validation Error',
                        'details' => $exception->validator->errors()->getMessages()
                    ]
                ]
            ], $exception->status);
        }

        if (env('APP_DEBUG')) {
            return parent::render($request, $exception);
        }
        return response()->json([
            'errors' => [
                [
                    'status' => strtolower(500),
                    'title' => 'Unexpected error. Try later',
                    'details' => $exception->getMessage()
                ]
            ]
        ], 500);
    }
}
