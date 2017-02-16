<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests\UpdatePassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('users.password.edit');
    }


    public function update(UpdatePassword $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        Auth::user()->fill($data);

        Auth::user()->save();

        return redirect()->back();
    }
}
