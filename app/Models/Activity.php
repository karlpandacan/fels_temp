<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'content', 'activity_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function scopeUserIds($query, $ids)
    {
        return $query->whereIn('user_id', $ids);
    }
}
