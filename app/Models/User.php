<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\AdminResetPasswordNotification;
use App\Notifications\ApiUserResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name',
        'phone',
        'gender',
        'email',
        'password',
        'status',
        'image',
        'role_id',
        'email_verify_token',   
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token', 
        'created_at',
        'updated_at',
        'email_verify_token',        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_url'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Overriding the vendor function
     * 
     * Send the password reset notification to the user
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // if admin
        if($this->role_id == 3){
            $this->notify(new ApiUserResetPasswordNotification($token));
        }else{
            $this->notify(new AdminResetPasswordNotification($token));
        }
    }


    public function getFullNameAttribute()
    {
        return ucwords($this->first_name. ' '. $this->last_name);
    }

    public function getImageUrlAttribute()
    {
        if($this->image){
            return url('/uploads/user/'. $this->image);
        }else{
            return url('/uploads/noavatar.jpg');
        }
    }

    public function deviceInfos()
    {
        $this->hasMany(UserDeviceInfo::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
