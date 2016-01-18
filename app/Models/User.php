<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'follower_id', 'followee_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        /*
         * USER TYPES
         * 0 = Non-admin
         * 1 = Admin
         */
        return $this->type == 1;
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function followees()
    {
        return $this->hasMany(Follow::class, 'followee_id');
    }

}
