<?php

namespace App\Http\Controllers\Admin;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use UploadTrait;
    // get change password
    public function getChangePassword()
    {
        return view('admin.auth.changePassword');
    }

    // change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => "required|string|confirmed",
            'password_confirmation' => "required|string" 
        ]);

        if(!Hash::check($request->old_password,auth()->user()->password))
        {
            return back()
                ->withErrors([
                    'old_password' => 'The given password doesnot match our records!'
                ]);
        }

        // update user with new password
        $admin = auth()->user();
        $admin->password = bcrypt($request->password);
        $admin->save();

        return back()
            ->withSuccess('Password has been changed successfully!');
    }
    
    // view profile
    public function getProfile(Request $request)
    {
        $admin = auth()->user();
        return view('admin.auth.profile', compact('admin'));
    }

    // update profile
    public function updateProfile(Request $request)
    {
        try {
            $admin = auth()->user();
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => "required|string",
                'email' => 'required|email|unique:users,email,'.$admin->id,
                'phone' => 'required|numeric|unique:users,phone,'.$admin->id,
                'image' => 'nullable'
            ]);
            $uploadedImage = $this->uploadImage($request, 'img', 'user');
            $request['image'] = $uploadedImage; 
        //    dd($request->all());
            $admin->update($request->all());

            return back()
                ->withSuccess('Profile updated successfully!');
    
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withError($e->getMessage());
        }        
    }
}
