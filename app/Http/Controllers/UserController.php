<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->simplePaginate();

        return view('user.index', compact('posts'));
    }
}
