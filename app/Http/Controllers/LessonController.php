<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonWord;
use App\Models\Category;
use Exception;
use Session;
use Auth;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        return view('lessons.home', ['categories' => $categories]);
    }

    public function create()
    {

    }

    /*
     * This block will generate the lesson id then redirect to another controller
     * for the generation of questions
     */
    public function store(Request $request)
    {
        $availableQuestions = Category::findOrFail($request->category_id)
            ->words()->userUnlearnedWords(auth()->user())->count();

        if($availableQuestions < 20) {
            session()->flash('flash_error',
                'There are not enough words left for your exam. Please try again later.');
            return redirect()->back();
        } else {
            try {
                $lesson = auth()->user()->lessons()->create(['category_id' => $request->category_id]);
            } catch (Exception $e) {
                session()->flash('flash_error',
                    'Your lesson could not be generated. Please try again later.');
                return redirect()->back();
            }

            // Route to LessonWordController to generate questions
            return redirect()->action(
                'LessonWordController@create',
                ['lesson_id' => $lesson->id, 'category_id' => $lesson->category_id]
            );
        }
    }

    public function show(Request $request, $lessonId)
    {
        if(empty($lessonId) || auth()->user()->lessons()->where('id', '=', $lessonId)->count() == 0) {
            return redirect()->back(); // Redirect if session variable of lesson id does not exist
        }

        $lesson = Lesson::findOrFail($lessonId)->lessonWords()->get();
        $score = $this->getCorrectAnswerCount($lesson);

        return view('lessons.results', [
            'user' => auth()->user(),
            'results' => $lesson,
            'count' => $score
        ]);
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    private function getCorrectAnswerCount($results)
    {
        $correctAnswers = 0;
        foreach($results as $result) {
            if($result->word_id == $result->word_answered_id) {
                $correctAnswers++;
            }
        }

        return (object) [
            'correct' => $correctAnswers,
            'total' => count($results)
        ];
    }

    public function storeActivity($lessonId)
    {
        $score = $this->getCorrectAnswerCount(Lesson::findOrFail($lessonId)->lessonWords()->get());

        auth()->user()->activities()->create([
            'lesson_id' => $lessonId,
            'content'   => 'Finished an exam with a score of ' . $score->correct . '/' . $score->total,
            'activity_type' => config()->get('activity_type.EXAM_TAKEN')
        ]);
    }
}
