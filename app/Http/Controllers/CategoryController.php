<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use Exception;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('categories.home', ['categories' => Category::all(), 'user' => \Auth::user()]);
    }

    public function create()
    {
        return view('categories.add');
    }

    public function store(Request $request)
    {
        try {
            $category = new Category;
            $category->assignValues($request);
            Session::flash('flash_success', 'Add successful!');
        } catch (Exception $e) {
            Session::flash('flash_error', 'Adding of category failed.');
        }

        return redirect('/categories');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('categories.edit', ['category' => $category]);
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', 'Edit failed. The category you are trying to edit cannot be found.');
        }

        return redirect('/categories');
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->assignValues($request);
            Session::flash('flash_success', 'Update successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', 'Update failed. The category you are trying to update cannot be found.');
        }

        return redirect('/categories');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            Session::flash('flash_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', 'Delete failed. The category you are trying to delete cannot be found.');
        }

        return redirect('/categories');
    }
}
