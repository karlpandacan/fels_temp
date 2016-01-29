<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Word;
use App\Models\Category;
use App\Models\LearnedWord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use Auth;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $words = Word::with('category')->paginate(20);
        return view('words.home', [
            'words' => $words,
            'user' => \Auth::user(),
            'categories' => Category::lists('name', 'id'),
            'status' => 'all',
            'category_id' => '1'
        ]);
    }

    public function create()
    {
        $categories = Category::lists('name', 'id');
        return view('words.add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        try {
            $word = new Word;
            $word->assignValues($request);
            Session::flash('flash_success', 'Adding of word successful!');
        } catch (Exception $e) {
            Session::flash('flash_error', 'Adding of word failed.');
        }

        return redirect('/words');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        try {
            $word = Word::findOrFail($id);
            $categories = Category::lists('name', 'id');
            return view('words.edit',
                ['word' => $word, 'categories' => $categories]);
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Edit failed. The word you are trying to edit cannot be found.');
        }

        return redirect('/words');
    }

    public function update(Request $request, $id)
    {
        try {
            $word = Word::findOrFail($id)->assignValues($request);
            Session::flash('flash_success', 'Update successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Update failed. The word you are trying to update cannot be found.');
        }

        return redirect('/words');
    }

    public function destroy($id)
    {
        try {
            $word = Word::findOrFail($id)->delete();
            Session::flash('flash_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error',
                'Delete failed. The word you are trying to delete cannot be found.');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->input('category')))  {
            $categoryId = $request->input('category');
        } else {
            $categoryId = 1;
        }

        $learnedWords = $user->learnedWords()->lists('word_id');

        switch($request->input('status')) {
            case "learned":
                $words = Word::where('category_id', $categoryId)
                    ->whereIn('id', $learnedWords)
                    ->paginate(20);
                break;

            case "unlearned":
                $words = Word::where('category_id', $categoryId)
                    ->whereNotIn('id', $learnedWords)
                    ->paginate(20);
                break;

            default: // Default is all words
                $words = Word::paginate(20);
                break;
        }

        return view('words.home', [
            'words' => $words,
            'user' => $user,
            'categories' => Category::lists('name', 'id'),
            'status' => $request->input('status'),
            'category_id' => $categoryId
        ]);
    }
}
