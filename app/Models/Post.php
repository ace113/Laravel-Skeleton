<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'image',
        'status',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $appends = [
        'date',
        'author',
        'image_url',
        'gist'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function getAuthorAttribute()
    {
        return $this->user->full_name;
    }

    public function getImageUrlAttribute()
    {
        if($this->image){
            return url('/uploads/posts/'. $this->image);
        }else{
            return url('/uploads/noavatar.jpg');
        }
    }

    public function getGistAttribute()
    {
        return $this->summary ? \Str::limit($this->summary, 225): '';
    }
}
