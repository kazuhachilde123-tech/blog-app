<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showDataInHome(){
        $post = Post::all();
        return view('home' , compact('post'));
    }

    public function showFullPost($id){
        $post = Post::findOrFail($id);
        return view('fullpost' , compact('post'));
    }
    public function home(Request $request)
    {
        if ($request->user()->role == "user") {
            return view('dashboard');
        }else{
            return redirect()->route('admin.dashboard');
        }
    }

    public function index(Request $request)
    {
        if ($request->user()->role == "admin") {
            return view('admin.dashboard');
        } else {
            return view('dashboard');
        }
    }
}
