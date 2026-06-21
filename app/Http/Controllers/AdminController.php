<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function addpost()
    {
        return view('admin.addpost');
    }

    public function createpost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $image = $request->file('image');
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img'), $imagename);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $imagename;
        $post->user_name = Auth::user()->name;
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()->route('admin.addpost')->with('status', 'Added Success');
    }

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $post->title = $request->title;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            $oldPath = public_path('img/' . $post->image);
            if ($post->image && file_exists($oldPath)) {
                @unlink($oldPath);
            }
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imagename);
            $post->image = $imagename;
        }

        $post->save();

        return redirect()->route('admin.posts')->with('status', 'Updated Success');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $imgPath = public_path('img/' . $post->image);
        if ($post->image && file_exists($imgPath)) {
            @unlink($imgPath);
        }

        $post->delete();

        return redirect()->route('admin.posts')->with('status', 'Deleted Success');
    }
}
