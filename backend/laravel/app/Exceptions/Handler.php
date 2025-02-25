<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Illuminate\Http\Response;

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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
    }

    /**
     * Update Unauthenticated.
     *
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->sendException($exception, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return mixed
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->sendException($exception, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->sendException($exception, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->sendException($exception, Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof InvalidSignatureException) {
            return $this->sendException($exception, Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return $this->sendException($exception, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return $this->sendException($exception, Response::HTTP_TOO_MANY_REQUESTS);
        }

        // return get_class($exception);

        return parent::render($request, $exception);
    }

    /**
     * @param \Exception  $exception
     * @param int $code
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendException($exception, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $exception->getMessage() !== ''? $exception->getMessage() : 'Not found',
            'status' => $code ],
        $code);
    }

    /**
     * @param \Throwable  $exception
     * @return 
     */
    public function report(Throwable $exception) 
    {
        // Kill reporting if this is an "access denied" (code 9) OAuthServerException.
        if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 9) {
            return $this->sendException($exception, Response::HTTP_UNAUTHORIZED);
        }

        parent::report($exception);
    }
}
