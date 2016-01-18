<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['category_id', 'word_japanese', 'word_vietnamese', 'sound_file'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function learnedWords()
    {
        return $this->hasMany(LearnedWord::class);
    }

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

    public function assignValues($values)
    {
        if($values->input('word_id') !== null) {
            $this->id = $values->input('word_id'); // Execute line if word will be updated
        }

        $this->category_id = $values->input('word_category');
        $this->word_japanese = $values->input('word_japanese');
        $this->word_vietnamese = $values->input('word_vietnamese');

        $this->save();
    }
}
