<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePost;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $posts = $user->posts()->simplePaginate();

        return view('post.index', compact('posts'));
    }

    public function show($uuid)
    {
        $post = Post::where('uuid', $uuid)->firstOrFail();

        return view('post.show', compact('post'));
    }

    public function store(CreatePost $request)
    {
        $post = new Post($request->all());

        Auth::user()->posts()->save($post);

        // Attach images here...
        try
        {
            $images = json_decode($request->get('images'));

            foreach($images as $image)
            {
                $post->images()->attach($image);
            }
        } catch (\Exception $e) { }

        return redirect()->route('home');
    }

    public function edit($uuid)
    {
        $post = Post::where('uuid', $uuid)->firstOrFail();

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $uuid)
    {
        $post = Post::where('uuid', $uuid)->firstOrFail();

        $post->fill($request->all());

        $post->save();

        return redirect()->route('post.show', $uuid);
    }

    public function delete(Request $request)
    {
        $post = Post::findOrFail($request->get('post'));

        $post->delete();

        return redirect()->to('/home');
    }
}
