<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => "No Existe Modelo", 'code' => 404], 404);
        }
        if ($exception instanceof MethodNotAllowedException) {
            return response()->json(['error' => "No permitido", 'code' => 401], 401);
        }
        if ($exception instanceof MethodNotFoundException) {
            return response()->json(['error' => "No Existe Metodo", 'code' => 404], 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => "No Existe Metodo Http", 'code' => 404], 404);
        }
        if ($exception instanceof ThrottleRequestsException) {
            return response()->json(['error' => "Bloqueado, muchas peticiones", 'code' => 429], 404);
        }
        return parent::render($request, $exception);
    }
}
