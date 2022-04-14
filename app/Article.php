<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Likeable;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->with('user');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable')->with('user');
    }
}
