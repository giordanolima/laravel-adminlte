<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            if (starts_with($request->getRequestUri(), '/admin') && method_exists($e->getModel(), 'errorData')) {
                return response(view('admin.templates.error', call_user_func(array($e->getModel(), 'errorData'))), 404);
            }
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        if (starts_with($request->getRequestUri(), '/admin')) {
            $data = [];
            if(!$e instanceof NotFoundHttpException){
                $data = [
                    'code' => method_exists($e, "getStatusCode") ? $e->getStatusCode() : 500,
                    'titulo' => "Ooops. Alguma coisa aconteceu",
                    'texto' => 'Desculpe. Um erro interno aconteceu. Favor reportar esse erro ao desenvolvedor.',
                    'link_route' => "jsvascript:history.go(-1)",
                    'link_texto' => 'Voltar',
                    'erro' => $e
                ];
            }
            return response(view('admin.templates.error',$data), 404);
        }

        return parent::render($request, $e);
    }
}
