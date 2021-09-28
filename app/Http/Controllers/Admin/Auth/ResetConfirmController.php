<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetConfirmController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }
    
   public function confirmReset()
   {
       return view('admin.auth.confirm');
   }
}
