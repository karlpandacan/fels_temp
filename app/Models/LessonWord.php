<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{
    protected $table = 'lesson_word';
    protected $fillable = ['lesson_id', 'word_id', 'word_answered_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function generateLessonWords($request)
    {
        // Fetch the ids of learned words to be used in querying the words that have not been learned yet
        // $learnedWords = LearnedWord::where('user_id', '=', \Auth::id())->select('id')->get();
        $learnedWords = \Auth::user()->learnedWords()->lists('id');
        $lessonWords = Word::with(['category', 'lessonWords'])
            ->whereNotIn('id', $learnedWords->toArray())
            ->orderBy(\DB::raw('RAND()'))
            ->take(5)
            ->get();

        $lessonWordsToInsert = [];
        foreach($lessonWords as $lessonWord) {
            $lessonWordsToInsert[] = [
                'lesson_id' => $request->lesson_id,
                'word_id' => $lessonWord->id,
                'word_answered_id' => null
            ];
        }

        try {
            \Eloquent::insert($lessonWordsToInsert);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}
