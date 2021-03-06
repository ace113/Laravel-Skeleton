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
}
