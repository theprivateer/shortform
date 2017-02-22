<?php

namespace App\Http\Controllers\Communities;

use App\Place;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function store(Request $request)
    {
        if($post = Post::where('uuid', $request->get('uuid'))->where('user_id', Auth::user()->id)->first())
        {
            $post->fill($request->all());
        } else
        {
            $post = new Post($request->all());
        }

        Auth::user()->posts()->save($post);

        // image
        if( ! empty($request->get('image')))
        {
            $post->image_payload = json_encode($request->get('image'));

            $post->save();
        }

        // place
        if($p = $request->get('place'))
        {
            $place = Place::firstOrCreate($p);

            $place->posts()->save($post);
        }

        return;
    }
}
