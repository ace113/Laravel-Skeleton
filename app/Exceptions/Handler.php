<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
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
     * @throws \Throwable
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($request->expectsJson()){
            $exception = $this->prepareException($exception);
            if($exception->getStatusCode() === 500){
                return $this->prepareResponse($request, $e);
            }
            // return $this->handleApiException($request, $exception);
        }
        return parent::render($request, $exception);
    }

    
    /**
     * Convert an authentication exception into a response.
     * 
     * @param Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function unauthenticated($request, AuthenticationException $exception)
    {
        $guards = $exception->guards();
        $guard = $guards[0];


        switch ($guard) {
            case 'api':
                return response()->json(['message' => $exception->getMessage()], 401);
                break;  
            case 'web':
                return redirect('/admin/login');
                break;        
            default:
                return redirect('/');
                break;
        }

        
        return $request->expectsJson() 
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect('/');
    }

    // handle api exception
    private function handleApiException($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
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
            $response['message'] = 'Unauthorized';
            break;
        case 403:
            $response['message'] = 'Forbidden';
            break;
        case 404:
            $response['message'] = 'Not Found';
            break;
        case 405:
            $response['message'] = 'Method Not Allowed';
            break;
        case 422:
            $response['message'] = $exception->original['message'];
            $response['errors'] = $exception->original['errors'];
            break;
        default:
            $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
            break;
    }

    if (config('app.debug')) {
        $response['trace'] = $exception->getTrace();
        $response['code'] = $exception->getCode();
    }

    $response['status'] = $statusCode;

    return response()->json($response, $statusCode);
}
}
