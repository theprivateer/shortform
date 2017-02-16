<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function edit()
    {
        return view('users.image.edit');
    }

    public function update(Request $request)
    {
        // Attach images here...
        try
        {
            $images = json_decode($request->get('images'));

            foreach($images as $image)
            {
                Auth::user()->avatar_id = $image;
            }
        } catch (\Exception $e) { }

        Auth::user()->save();

        return redirect()->back();
    }
}
