<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'content', 'activity_type'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function lesson()
    {
        $this->belongsTo(Lesson::class);
    }
}
