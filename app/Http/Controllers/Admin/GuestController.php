<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class GuestController extends Controller
{
    use SendsPasswordResetEmails;

    // Where to redirect user after login
    protected $redirectTo = 'admin/dashbaord';

    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }
    
    // Get Login From
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    // login
    public function login(Request $request)
    {
        // validate
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        if(Auth::guard('web')->attempt($credentials, $request->remember)){
            if(auth()->user()->role_id == 3){
                Auth::guard('web')->logout();
            }
            return redirect()->intented($this->redirectTo);
        }
    }

    // logout
    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('admin.login.form');
    }

  
    // send reset link email
    // public function sendResetLinkEmail(Request $request)
    // {
    //     // validate email
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $response = $this->broker()->sendResetLink(
    //         $this->credentials($request)
    //     );

    //     return response()->json(['hello', $response]);die();

    //     return $response == Password::RESET_LINK_SENT
    //                 ? $this->sendResetLinkResponse($request, $response)
    //                 : $this->sendResetLinkFailedResponse($request, $response);
    // }

    // reset password form
    public function getResetPassword()
    {

    }

    // reset password
    public function resetPassword()
    {
        
    }

    /**
     * Get the broker to be used during password reset
     */
    public function broker()
    {
        return Password::broker();
    }

}
