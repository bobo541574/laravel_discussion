<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getCommentCheckAttribute()
    {
        return $this->user_id == auth()->user()->id;
    }
    public function getBodyAttribute()
    {
        if(mb_detect_encoding($this->content) == 'UTF-8') {
            if(strlen($this->content > 340) == "true"){
                return substr($this->content, 0, 340).substr($this->content, 340, 580);
            }
        }else {
            if(strlen($this->content > 130) == "true") {
                return substr($this->content, 0, 130);
            }else {
                return $this->content;
            }
        }
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}