<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unlike extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likeable()
    {
        return $this->morphTo();
    }
}