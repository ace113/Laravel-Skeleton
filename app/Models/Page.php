<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillables = [
        'title',
        'slug',
        'body',
        'image',
        'status',
    ];
}
