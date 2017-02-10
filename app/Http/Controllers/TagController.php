<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($tag)
    {
        $posts = Post::withAnyTags([$tag])->latest()->paginate();

        return view('tag.index', compact('tag', 'posts'));
    }
}
