<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\LessonWord;

class LearnedWordController extends Controller
{
    public function store(Request $request)
    {
        Auth::user()->learnedWords()->create(['word_id' => $request->word_id]);
    }
}
