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
        'name',
        'email',
        'password',
        'follower_id',
        'followee_id',
        'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        return $this->belongsToMany(User::class, 'follows', 'followee_id',
            'follower_id');
    }

    public function followees()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id',
            'followee_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function learnedWords()
    {
        return $this->hasMany(LearnedWord::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function uploadImage($request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . $file->getClientOriginalName();
            $file->move('images/profile_picture', $filename);
            return 'images/profile_picture/' . $filename;
        } else {
            return '';
        }
    }

    public function scopeFindUser($query, $wildcard)
    {
        return $query->where('name', 'like', '%' . $wildcard . '%')
            ->orwhere('email', 'like', '%' . $wildcard . '%');
    }

    public function scopeOfNotIds($query, $ids)
    {
        return $query->whereNotIn('id', $ids);
    }

    public function getLearnedWordsIds()
    {
        return $this->learnedWords->lists('word_id');
    }
}
