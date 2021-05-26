<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

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

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        $errorCode = $e->getStatusCode();
        if (!view()->exists('errors.' . $errorCode)) {
            return response()->view(
                'errors.default',
                [
                    'code' => $errorCode,
                    'message' => __('http-code.' . $errorCode)
                ],
                $errorCode,
                $e->getHeaders()
            );
        }

        return parent::renderHttpException($e);
    }
}
