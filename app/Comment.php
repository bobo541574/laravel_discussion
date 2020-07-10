<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getCommentCheckAttribute()
    {
        return Auth::check() ? $this->user_id == auth()->user()->id : '';
    }
    public function getBodyAttribute()
    {
        if (mb_detect_encoding($this->content) == 'UTF-8') {
            if (strlen($this->content) > 10 == true) {
                return mb_substr($this->content, 0, 280, 'UTF-8');
            }
        } else {
            if (strlen($this->content) > 240 == true) {
                return substr($this->content, 0, 240);
            } else {
                return $this->content;
            }
        }
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}