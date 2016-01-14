<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\User;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(\Auth::id());
        return view('categories.home', ['categories' => Category::all(), 'user' => $user]);
    }

    public function create()
    {
        return view('categories.add');
    }

    public function store(Request $request)
    {
        $category = new Category;

        $this->assignValues($category, $request);

        return redirect('/categories');
    }

    public function show($id)
    {
        return Category::find($id);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->assignValues($category, $request);

        return redirect('/categories');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);

        $category->delete();

        return redirect('/categories');
    }

    private function assignValues($category, $values)
    {
        if($values->input('category_id') !== null) {
            $category->id = $values->input('categoryId'); // Execute line if category will be updated
        }

        $category->name = $values->input('categoryName');
        $category->description = $values->input('categoryDesc');

        if(!empty($values->input('categoryImage')) || ($values->input('categoryImage')) == null) {
            $category->image = $values->input('categoryImage'); // Execute line if an image is set
        }

        $category->save();
    }
}
