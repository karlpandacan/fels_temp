<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['category_id', 'word_japanese', 'word_vietnamese', 'sound_file'];

    public function category()
    {
        $this->belongsTo(Category::word);
    }

    public function learnedWords()
    {
        $this->hasMany(LearnedWord::class);
    }

    public function lessonWords()
    {
        $this->hasMany(LessonWord::class);
    }
}
