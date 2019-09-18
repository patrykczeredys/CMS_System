<?php

namespace App\Http\Controllers;

use File;
use Session;
use Validator;
use App\Posts;
use App\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Posts::all();

        return view('post.main')
            ->with('posts',$posts);
    }

    public function create() {
        $categories = array();

        foreach (Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('post.create')->with('categories', $categories);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|min:3|max:100',
            'author' => 'required|min:3|max:20',
            'image' => 'required|mimes:jpg,jpeg,png,gif',
            'short_desc' => 'required|min:20|max:300',
            'description' => 'required|min:50'
        ]);

        if($validator->fails()) {
            return redirect('post/create')
                ->withInput()
                ->withErrors($validator);
        }

        //Create The Post

        $image = $request->file('image');
        $upload = 'img/posts/';
        $filename = time().$image->getClientOriginalName();
        $path = move_uploaded_file($image->getPathName(), $upload.$filename);

        $post = new Posts;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->author = $request->author;
        $post->image = $filename;
        $post->short_desc = $request->short_desc;
        $post->description = $request->description;
        $post->save();

        Session::flash('post_create', 'New post is created!');

        return redirect('post/create');
    }

    public function edit($id) {
        $categories = array();

        foreach (Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }
        $posts = Posts::findOrFail($id);

        return view('post.edit')
            ->with('posts', $posts)
            ->with('categories', $categories);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|min:3|max:100',
            'author' => 'required|min:3|max:20',
            'image' => 'mimes:jpg,jpeg,png,gif',
            'short_desc' => 'required|min:20|max:300',
            'description' => 'required|min:50'
        ]);

        $post = Posts::find($id);

        if($validator->fails()) {
            return redirect('post/'.$post->id.'/edit')
                ->withInput()
                ->withErrors($validator);
        }

        //Update post
        if($request->file('image') != "") {
            $image = $request->file('image');
            $upload = 'img/posts/';
            $filename = time().$image->getClientOriginalName();
            $path = move_uploaded_file($image->getPathName(), $upload.$filename);
        }

        $post->category_id = $request->category_id;
        $post->title = $request->Input('title');
        $post->author = $request->Input('author');
        if(isset($filename)) {
            $post->image = $filename;
        }
        $post->short_desc = $request->Input('short_desc');
        $post->description = $request->Input('description');
        $post->save();

        Session::flash('post_update', 'Post is updated!');

        return redirect('post');
    }

    public function destroy($id) {
        $post = Posts::find($id);

        $image_path = 'img/posts/'.$post->image;
        File::delete($image_path);

        $post->delete();

        Session::flash('post_delete', 'Post is delete!');

        return redirect('post');
    }
}
