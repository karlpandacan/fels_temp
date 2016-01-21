<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LessonWord;
use App\Models\LearnedWord;
use App\Models\Word;

class LessonWordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

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
            if($lessonWord->generateLessonWords($request)) {
                return redirect('/'); // TEMPORARY, REDIRECT TO TEST ONCE DONE
            }
        } catch(Exception $e) {
            \Session::flash('flash_error', 'Lesson generation failed. Please try again later.');
        }

        return redirect('categories');
    }

    public function show()
    {

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
}
