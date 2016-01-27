<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LessonWord;
use App\Models\LearnedWord;
use App\Models\Lesson;
use App\Models\Word;
use Session;
use Exception;

class LessonWordController extends Controller
{
    public function __construct()
    {
        // Keep some session flash variables so that users could refresh the page in case they lose connection for a while
        Session::keep('lessonId');
        Session::keep('maxQuestions');
        Session::keep('questionIndex');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /*
         * Session::keep here is used to retain the lesson id even if the user refreshes the page
         * this keeps the lesson id hidden to the user and inaccessible by anyone else
         * the lesson id is not retained when navigating away from the page so the page will be inaccessible once done
         */
        $lessonId = Session::get('lessonId');

        // If lesson id does not exist in the session, do not allow access to the page
        if(!isset($lessonId)) {
            return redirect('lessons');
        }

        $user = \Auth::user();
        $words = Word::orderBy(\DB::raw('RAND()'))->take(80)->get();

        $questions = LessonWord::with('word')->where('lesson_id', $lessonId)->get();
        Session::flash('maxQuestions', count($questions));

        if(empty(Session::get('questionIndex'))) {
            Session::flash('questionIndex', 0); // Start with index zero
        } else {
            Session::keep('questionIndex');
        }

        $generatedOptions = $this->generateOptions($questions, $words); // Pass this to view
        if($generatedOptions == null) {
            return redirect('lessons'); // Return users to lesson page if they try to go back to the finished exam
        }

        return view('lessons.exam', ['user' => $user, 'questions' => $questions, 'options' => $generatedOptions]);
    }

    public function create(Request $request)
    {
        return $this->store($request);
    }

    /*
     * This is the block responsible for creating the questions
     */
    public function store(Request $request)
    {
        $lessonWord = new LessonWord;
        try {
            if($lessonWord->generateLessonWords($request) != false) {
                $lessonId = $lessonWord->getLastLessonId();
                Session::flash('lessonId', $lessonId); // Flash the lesson id into the session

                return redirect('exams'); // Redirect user to the exam page
            }
        } catch(Exception $e) {
            Session::flash('flash_error',
                'Lesson generation failed. Please try again later.');
        }

        return redirect('categories');
    }

    public function show(Request $request, $lessonId)
    {
        $user = \Auth::user();

        if(empty($lessonId) || $user->lessons()->where('id', '=', $lessonId)->count() == 0) {
            return redirect('lessons'); // Redirect if session variable of lesson id does not exist
        }

        $lessonWord = new LessonWord;
        $results = $lessonWord->with(['word', 'wordAnswered', 'word.category'])
            ->where('lesson_id', $lessonId)
            ->get();
        $correctAnswerCount = $lessonWord->getCorrectAnswerCount($results);

        return view('lessons.results', [
            'user' => $user,
            'results' => $results,
            'count' => $correctAnswerCount
        ]);
    }

    public function edit()
    {

    }

    public function update(Request $request)
    {
        try {
            $id = intval($request->input('lesson_word_id'));
            $lessonWord = LessonWord::findOrFail($id)->setAnswer($request);
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Your answer cannot be saved. Please try again later.');
        }

        $nextIndex = intval(Session::get('questionIndex')) + 1;
        if($nextIndex < Session::get('maxQuestions')) {
            Session::flash('questionIndex', $nextIndex);
            return redirect('exams');
        } else {
            Session::flash('questionIndex', $nextIndex); // Add another one to prevent users from going back
            return redirect('results/' . Session::get('lessonId'));
        }
    }

    public function destroy()
    {

    }

    /*
     * This separate code block was made to make code more readable
     * $lessonWord is the question itself
     * $words is the collection of words where we will take the possible answers from
     */
    private function generateOptions($lessonWord, $words)
    {
        $generatedStuff = [];
        try {
            $usedWordIds[] = $lessonWord[Session::get('questionIndex')]->word->id;
            $indexForAnswer = rand(0, 3); // Randomize index for the answer
            for($i = 0; $i < 4; $i++) {
                if($i == $indexForAnswer) {
                    $generatedStuff[] = [
                        'id' => $lessonWord[Session::get('questionIndex')]->word->id,
                        'word_japanese' => $lessonWord[Session::get('questionIndex')]->word->word_japanese,
                        'word_vietnamese' => $lessonWord[Session::get('questionIndex')]->word->word_vietnamese
                    ];
                } else {
                    do {
                        $optionIndex = rand(0, count($words) - 1);
                    } while($words[$optionIndex]['id'] == $lessonWord[Session::get('questionIndex')]->word->id ||
                            in_array($words[$optionIndex]['id'], $usedWordIds)
                        );
                    $generatedStuff[] = [
                        'id' => $words[$optionIndex]['id'],
                        'word_vietnamese' => $words[$optionIndex]['word_vietnamese']
                    ];
                    $usedWordIds[] = $words[$optionIndex]['id'];
                    // unset($words[$optionIndex]);
                }
            }
        } catch (Exception $error) {
            return null;
        }

        return $generatedStuff;
    }
}
