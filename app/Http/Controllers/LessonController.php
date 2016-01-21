<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lessons = Lesson::all();
        return view('lessons.home', ['lessons' => $lessons]);
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
        try {
            $lesson = \Auth::user()->lessons()->create(['category_id' => 1]); // TEMPORARILY FIXED UNTIL CATEGORY'S FRONT END IS NOT YET DONE
        } catch(Exception $e) {
            \Session::flash('flash_error', 'Your lesson could not be generated. Please try again later.');
            return redirect()->back();
        }
        // Route to LessonWordController to generate questions
        return redirect()->action(
            'LessonWordController@create',
            ['lesson_id' => $lesson->id, 'category_id' => $lesson->category_id]
        );
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
