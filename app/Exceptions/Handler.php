<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $TraceException = [
            'class' => get_class($exception),
            'file' => $exception->getFile(),
            'line_of_code' => $exception->getLine(),
            'code' => $exception->getCode(),
            'trace' => $exception->getTraceAsString()
        ];

        if ($exception instanceof ModelNotFoundException) {
            $arrModel = explode("\\",$exception->getModel());
            $model = end($arrModel);
            return renderResponse([
                'status' => FALSE, 
                'message' => ucfirst($model.' '.config('mamikos.message.data_not_found'))
            ],404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return renderResponse([
                'status' => FALSE, 
                'message' => config('mamikos.message.route_not_found'),
                // 'exception' => $TraceException
            ],404);
        }

        if($exception instanceof \Illuminate\Auth\AuthenticationException ){
            return renderResponse([
                'status' => FALSE, 
                'message' => $exception->getMessage()
            ],401);
        }

        if($exception instanceof ValidationException){
            $errors = [];
            foreach ($exception->errors() as $key => $value) {
                $errors[] = $value[0];

                if($key==0){break;} 
            }
            return renderResponse([
                'status' => FALSE, 
                'message' => $errors[0]
            ],400);
        }

        $response = [
            'status' => FALSE,
            'message' => config('mamikos.message.route_not_found')
        ];
        // return parent::render($request, $exception);
        return renderResponse($response, 404);
    }
}
