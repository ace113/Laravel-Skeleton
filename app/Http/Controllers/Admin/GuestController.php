<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Auth\Events\PasswordReset;


class GuestController extends Controller
{    
    // Where to redirect user after login
    protected $redirectTo = 'admin/dashboard';

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
    public function login(LoginRequest $request)
    {

        $credentials = $request->only(['email', 'password']);

        if(Auth::guard('web')->attempt($credentials, $request->remember)){
            if(auth()->user()->role_id == 3){
                Auth::guard('web')->logout();
            }
            return redirect()->intended($this->redirectTo);
        }
        return back()
            ->withInput()
            ->withError('The provided credentials donot match any of our records!');
    }

    // logout
    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('admin.login.form');
    }

   

   

    

}
