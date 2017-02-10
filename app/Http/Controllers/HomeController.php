<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(config('shortform.user-timelines')) return view('home.welcome');

        $posts = Post::latest()->simplePaginate();

        return view('home.index', compact('posts'));
    }
}
