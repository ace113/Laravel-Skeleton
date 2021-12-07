<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check() && (auth()->user() instanceof MustVerifyEmail && !auth()->user()->hasVerifiedEmail())){
            auth()->logout();
            return response()->json([
                "message" => "You need to confirm you account. We have sent you an activation link to you email."
            ], 422);
        }
        return $next($request);
    }
}
