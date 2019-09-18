<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use Session;

class CategoryController extends Controller
{
    
    public function index() {
        $categories = category::all();

        return view('category.main')->with('categories', $categories);
    }

    public function create() {
        return view('category.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|min:3'
        ]);

        if($validator->fails()) {
            return redirect('category/create')
                ->withInput()
                ->withErrors($validator);
        }

        //Create category

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        Session::flash('category_create', 'New category is created!');

        return redirect('category/create');
    }

    public function edit($id) {
        $categories = Category::findOrFail($id);

        return view('category.edit')->with('categories', $categories);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|min:3'
        ]);

        if($validator->fails()) {
            return redirect('category/'.$category->id.'/edit')
                ->withInput()
                ->withErrors($validator);
        }

        //Create category

        $category = Category::find($id);
        $category->name = $request->Input('name');
        $category->save();

        Session::flash('category_update', 'Category is update!');

        return redirect('category');
    }

    public function destroy($id) {
        $categories = Category::find($id);

        $categories->delete();

        Session::flash('category_delete', 'Category is delete!');

        return redirect('category');
    }
}