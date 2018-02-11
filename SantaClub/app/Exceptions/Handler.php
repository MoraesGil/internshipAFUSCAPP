<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
  * @param  \Exception  $exception
  * @return void
  */
  public function report(Exception $exception)
  {
    parent::report($exception);
  }

  /**
  * Render an exception into an HTTP response.
  *
  * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
  * @param  \Illuminate\Http\Request  $request
  * @param  \Exception  $exception
  * @return \Illuminate\Http\Response
  */
  public function render($request, Exception $exception)
  {
    $status = 500;//DEFAULT
    $trace = $exception->getTrace()[0]['class'];
    $msg = 'msg->'.$exception->getMessage().' | trace-> '.$trace;

    if ($exception->getMessage() == 'Unauthenticated.' || $trace == 'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken') {
      $status = 401;
    }

    if ($request->expectsJson()) {

      if ($status == 401) {
        return response()->json([
          'message' => 'Autenticação requerida.',
          'errors'  => 'Sua sessão expirou, faça login novamente'
        ], $status);
      }

      if (env('APP_DEBUG') === false) {
        return response()->json([
          'message' => 'Informe o administrador do sistema',
          'errors'  => [encrypt($msg)]
        ], $status);
      }else {
        return response()->json([
          'errors'  => [$msg]
        ], $status);
      }

    }

    if ($status == 401) {
      return redirect()->guest('login');
    }

    return parent::render($request, $exception);
  }

  /**
  * Convert an authentication exception into an unauthenticated response.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Illuminate\Auth\AuthenticationException  $exception
  * @return \Illuminate\Http\Response
  */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($request->expectsJson()) {
      return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    return redirect()->guest('login');
  }
}
