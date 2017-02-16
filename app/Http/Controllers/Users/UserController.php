<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests\UpdateUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit()
    {
        return view('users.user.edit');
    }

    public function password()
    {
        return view('users.user.password');
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
