<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{
    protected $fillable = ['lesson_id', 'word_id', 'word_answered_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
