<?php

namespace App\Exceptions;

use PDOException;
use App\Http\Controllers\ErrorController;
use App\Model\Role;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof EngineBootException) {
            dd('We are actively working on the server configurations, please wait..');
        }

        if ($this->isDeveloper() == true) {
            return parent::render($request, $exception);
        }

        if ($this->hasDisabledSite()) {
            return ErrorController::maintenance();
        }

        if ($exception instanceof NotFoundHttpException) {
            return ErrorController::unknown();
        }

        if ($exception instanceof PDOException) {
            return ErrorController::database();
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * See if the site has been disabled by the tenant for maintenance errors.
     *
     * @return bool
     */
    private function hasDisabledSite()
    {
        return settings()->getValue('enable_website') == false;
    }

    /**
     * Check that the current user is a developer
     *
     * @return bool
     */
    private function isDeveloper()
    {
        if(auth()->check() == false)
            return false;

        return account()->hasRole(Role::SUPERUSER);
    }
}