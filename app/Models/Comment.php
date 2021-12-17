<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'status',
        'email',
        'name',
        'parent_id',
        'user_id',
    ];

    protected $appends = ['date'];

    public function getDateAttribute()
    {
        if($this->updated_at)
        {
            return $this->updated_at->diffForHumans();
        }
        $this->created_at->diffForHumans();
    }


    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
