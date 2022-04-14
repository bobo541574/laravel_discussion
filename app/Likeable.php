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
        return $this->likes()->where('liked', true)->count() ?: '';
    }

    public function liker($user_id, $liked)
    {
        $liker = $this->likes()->where('user_id', $user_id)->first();

        if ($this->likeCheck) {

            return $this->change($liker, $liked);
        } elseif ($this->dislikeCheck) {

            return $this->change($liker, $liked);
        } else {

            $like = new Like();
            $like->user_id = $user_id;
            $like->likeable_id = $this->id;
            $like->liked = $liked;

            return [
                "status"    => 201,
                "data"      => $this->likes()->save($like),
            ];
        }
    }

    protected function change($liker, $liked)
    {
        if ($liked == $liker->liked)
            return [
                "status"    => 200,
                "data"      => $liker->delete(),
            ];

        $liker->liked = $liked;
        return [
            "status"    => 201,
            "data"      => $liker->save(),
        ];
    }

    /* End - likes */

    /* Start - unlikes */
    public function getdislikeCheckAttribute()
    {
        return Auth::check() ? (bool) $this->likes()->where(['user_id' => auth()->user()->id, 'liked' => false])->exists() : null;
    }

    public function getdislikeCountAttribute()
    {
        return $this->likes()->where('liked', false)->count() ?: '';
    }
    /* End - unlikes */
}
