<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceInfo extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'device_type',
        'device_token',
    ];
}
