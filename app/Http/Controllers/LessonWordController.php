<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LessonWord;
use App\Models\LearnedWord;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\Activity;
use Session;
use Exception;

class LessonWordController extends Controller
{
    public function __construct()
    {
        // Keep some session flash variables so that users could refresh the page in case they lose connection for a while
        session()->keep('lessonId');
        session()->keep('maxQuestions');
        session()->keep('questionIndex');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /*
         * session()->keep here is used to retain the lesson id even if the user refreshes the page
         * this keeps the lesson id hidden to the user and inaccessible by anyone else
         * the lesson id is not retained when navigating away from the page so the page will be inaccessible once done
         */
        $lessonId = session('lessonId');

        // If lesson id does not exist in the session, do not allow access to the page
        if(!isset($lessonId)) {
            return redirect('lessons');
        }

        $user = auth()->user();
        $words = Word::orderBy(\DB::raw('RAND()'))->take(80)->get();

        $questions = LessonWord::with('word')->where('lesson_id', $lessonId)->get();
        session()->flash('maxQuestions', count($questions));

        if(empty(session('questionIndex'))) {
            session()->flash('questionIndex', 0); // Start with index zero
        } else {
            session()->keep('questionIndex');
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
            if($lessonWord->generateLessonWords($request, auth()->user()) != false) {
                $lessonId = $lessonWord->getLastLessonId(auth()->id());
                session()->flash('lessonId', $lessonId); // Flash the lesson id into the session

                return redirect('exams'); // Redirect user to the exam page
            }
        } catch(Exception $e) {
            session()->flash('flash_error',
                'Lesson generation failed. Please try again later.');
        }

        return redirect('lessons');
    }

    public function show()
    {

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
            session()->flash('flash_error',
                'Your answer cannot be saved. Please try again later.');
        }

        $nextIndex = intval(session('questionIndex')) + 1;
        if($nextIndex < session('maxQuestions')) {
            session()->flash('questionIndex', $nextIndex);
            return redirect('exams');
        } else {
            session()->flash('questionIndex', $nextIndex); // Add another one to prevent users from going back

            redirect()->action(
                'LessonController@storeActivity',
                ['lessonId' => session('lessonId')]
            );

            return redirect('results/' . session('lessonId'));
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
        $generatedOptions = [];
        try {
            $usedWordIds[] = $lessonWord[session('questionIndex')]->word->id;
            $indexForAnswer = rand(0, 3); // Randomize index for the answer
            for($i = 0; $i < 4; $i++) {
                if($i == $indexForAnswer) {
                    $generatedOptions[] = [
                        'id' => $lessonWord[session('questionIndex')]->word->id,
                        'word_japanese' => $lessonWord[session('questionIndex')]->word->word_japanese,
                        'word_vietnamese' => $lessonWord[session('questionIndex')]->word->word_vietnamese
                    ];
                } else {
                    do {
                        $optionIndex = rand(0, count($words) - 1);
                    } while($words[$optionIndex]['id'] == $lessonWord[session('questionIndex')]->word->id ||
                            in_array($words[$optionIndex]['id'], $usedWordIds)
                        );
                    $generatedOptions[] = [
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

        return $generatedOptions;
    }
}
