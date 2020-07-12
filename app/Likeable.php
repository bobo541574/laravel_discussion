<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait Likeable
{
    /* Start - likes */
    public function getlikeCheckAttribute()
    {
        return Auth::check() ? (bool) $this->likes()->where(['user_id' => auth()->user()->id, 'liked' => true])->exists() : null;
    }

    public function getlikeCountAttribute()
    {
        return $this->likes()->where('liked', true)->count() > 0 ? $this->likes()->where('liked', true)->count() : '';
    }

    public function liker($likeable, $user_id, $liked)
    {
        if ($this->likeCheck) {
            $dislike = $this->find($likeable->id)
                ->likes()->where(['likeable_id' => $likeable->id, 'user_id' => $user_id, 'liked' => true])
                ->first();
            $dislike->liked = $liked;
            $dislike->save();

            return $dislike;
        } else if ($this->dislikeCheck) {
            $like = $this->find($likeable->id)
                ->likes()->where(['likeable_id' => $likeable->id, 'user_id' => $user_id, 'liked' => false])
                ->first();
            $like->liked = $liked;
            $like->save();

            return $like;
        }

        $like = new Like();
        $like->user_id = $user_id;
        $like->likeable_id = $likeable->id;
        $like->liked = $liked;
        $likeable->likes()->save($like);
        // $like->save();

        return $like;
    }

    /* End - likes */

    /* Start - unlikes */
    public function getdislikeCheckAttribute()
    {
        return Auth::check() ? (bool) $this->likes()->where(['user_id' => auth()->user()->id, 'liked' => false])->exists() : null;
    }

    public function getdislikeCountAttribute()
    {
        return $this->likes()->where('liked', false)->count() > 0 ? $this->likes()->where('liked', false)->count() : '';
    }
    /* End - unlikes */
}