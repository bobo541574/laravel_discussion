<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password', 'photo'
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getphotoAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function timeline()
    {
        return $this->articles();
    }

    public function articles()
    {
        return $this->hasMany('App\Article', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function unlikes()
    {
        return $this->hasMany('App\Unlike');
    }
}