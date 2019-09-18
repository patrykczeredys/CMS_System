<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index() {
        return view('store.main')
            ->with('posts', Posts::orderBy('created_at', 'DESC')->get());
    }

    public function getView($id) {
        return view('store.view')
            ->with('post', Posts::find($id));
    }
}
