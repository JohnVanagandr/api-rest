<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
  use ApiResponser;

  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
    //
  ];
  /**
   * The list of the inputs that are never flashed to the session on validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Report or log an exception.
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
   * Register the exception handling callbacks for the application.
   */
  public function register(): void
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
    if ($exception instanceof ValidationException) {
      return $this->convertValidationExceptionToResponse($exception, $request);
    }
    if ($exception instanceof ModelNotFoundException) {
      $modelo = strtolower(class_basename($exception->getModel()));
      return $this->errorResponse("No existe ninguna instancia de modelo {$modelo} con el id especificado", 404);
    }

    if ($exception instanceof AuthenticationException) {
      return $this->unauthenticated($request, $exception);
    }

    if ($exception instanceof AuthorizationException) {
      return $this->errorResponse("No posee permisos para ejecutar esta acción", 403);
    }

    if ($exception instanceof NotFoundHttpException) {
      return $this->errorResponse("No se encontró la URL especificada", 404);
    }

    if ($exception instanceof MethodNotAllowedHttpException) {
      return $this->errorResponse("El método especificado en la petición no es valido", 405);
    }

    if ($exception instanceof HttpException) {
      return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
    }

    if ($exception instanceof QueryException) {
      $codigo = $exception->errorInfo[1];
      if ($codigo == 1451) {
        return $this->errorResponse("No se puede eliminar de forma permanente el recurso porque está relacionado con algún otro recurso.", 409);
      }
    }

    if ($exception instanceof TokenMismatchException) {
      return redirect()->back()->withInput($request->input());
    }

    if (config('app.debug')) {
      return $this->errorResponse("Falla inesperada. Intente luego", 500);
    }

    return parent::render($request, $exception);
  }

  /**
   * Convert an authentication exception into a response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Illuminate\Auth\AuthenticationException  $exception
   * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
   */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($this->isFrontend($request)) {
      return redirect()->guest('login');
    }
    return $this->errorResponse("No autenticado.", 401);
  }


  /**
   * Create a response object from the given validation exception.
   *
   * @param  \Illuminate\Validation\ValidationException  $e
   * @param  \Illuminate\Http\Request  $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  protected function convertValidationExceptionToResponse(ValidationException $e, $request)
  {
    $errors = $e->validator->errors()->getMessages();

    if ($this->isFrontend($request)) {
      return $request->ajax() ? response()->json($errors, 422) : redirect()
        ->back()
        ->withInput()
        ->withErrors($errors);
    }
    return $this->errorResponse($errors, 422);
  }

  // Método para validar que sea solicitudes desde la aplicación web del proyecto
  private function isFrontend($request)
  {
    return $request->acceptsHtml() &&  collect($request->route()->middleware())->contains('web');
  }
}
