<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;

class VerificatonController extends ApiController
{
    use VerifiesEmails;

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Resend the email verification notification
     */
    public function resend(Request $request)
    {
        if($request->user()->hasVerifiedEmail()){
            $this->response['message'] = "Email has been already verified.";
            return $this->respondWithError($this->response);
        }

        $request->user()->sendEmailVerificationNotification();
        if($request->wantsJson()){
            $this->response['message'] = 'Email has been sent.';
            return $this->respondWithSuccess($this->response);
        }

        return back();

    }

    /**
     * Verify email
     */
    public function verify(Request $request)
    {
        auth()->loginUsingId($request->route('id'));

        if($request->route('id') != $request->user()->getKey()){
            throw new AuthorizationException;
        }

        if($request->user()->hasVerifiedEmail()){
            $this->response['message'] = "Email has been already verified.";
            return $this->respondWithError($this->response);
        }

        if($request->user()->markEmailAsVerified()){
            event(new Verified($request->user()));
        }

        $this->response['message'] = 'Email verification successfull.';
        return $this->respondWithSuccess($this->response);
    }
}
