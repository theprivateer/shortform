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

    public function edit()
    {
        return view('user.edit');
    }

    public function update(UpdateUser $request)
    {
        $data = $request->all();

        if(empty($data['password']))
        {
            unset($data['password']);
        } else
        {
            $data['password'] = bcrypt($data['password']);
        }

        Auth::user()->fill($data);

        Auth::user()->save();

        return redirect()->back();
    }
}
