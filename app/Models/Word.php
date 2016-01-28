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
        $data = [
            'category_id' => $values->input('word_category'),
            'word_japanese' => $values->input('word_japanese'),
            'word_vietnamese' => $values->input('word_vietnamese')
        ];

        if(!empty($values->file('sound_file'))) {
            $data = $this->saveSound($data, $values);
        }

        if($values->input('word_id') == null) {
            $this->firstOrCreate($data);
        } else {
            $this->update($data);
        }
    }

    private function saveSound($data, $values)
    {
        $soundFileName = $this->sound_file;
        if(empty($this->sound_file)) {
            $soundFileName = $this->generateName($values); // Create new name;
        }

        $values->file('sound_file')->move(base_path() . '/public/audio/', $soundFileName);
        $data['sound_file'] = $soundFileName;

        return $data;
    }

    private function generateName($values)
    {
        return uniqid() . '.' . $values->file('sound_file')->getClientOriginalExtension();
    }
}
