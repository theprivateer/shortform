<?php

namespace App\Http\Controllers;

use App\Place;
use App\Post;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index($id)
    {
        $place = Place::where('id', $id)->firstOrFail();

        $posts = Post::where('place_id', $place->id)->latest()->paginate();

        return view('place.index', compact('place', 'posts'));
    }
}
