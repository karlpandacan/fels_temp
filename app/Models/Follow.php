<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['followee_id', 'follower_id'];

    public function followee()
    {
        return $this->belongsTo(User::class, 'followee_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
