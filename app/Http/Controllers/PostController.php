<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePost;
use App\Jobs\SyndicatePost;
use App\Place;
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

    public function show($user, $uuid)
    {
        $post = Post::where('user_id', $user)->where('uuid', $uuid)->firstOrFail();

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

        // Place
        try
        {
            $p = json_decode($request->get('raw_place'));

            $place = Place::firstOrCreate([
                'object_id' => $p->hit->objectID,
                'name'      => $p->name,
                'value'     => $p->value,
                'latitude'  => $p->latlng->lat,
                'longitude' => $p->latlng->lng,
            ]);

            $place->posts()->save($post);

        } catch (\Exception $e) { }

        dispatch(new SyndicatePost($post));

        return redirect()->route('home');
    }

    public function edit($user, $uuid)
    {
        $post = Post::where('user_id', $user)->where('uuid', $uuid)->firstOrFail();

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $user, $uuid)
    {
        $post = Post::where('user_id', $user)->where('uuid', $uuid)->firstOrFail();

        $post->fill($request->all());

        $post->save();

        // Place
        try
        {
            $p = json_decode($request->get('raw_place'));

            $place = Place::firstOrCreate([
                'object_id' => $p->hit->objectID,
                'name'      => $p->name,
                'value'     => $p->value,
                'latitude'  => $p->latlng->lat,
                'longitude' => $p->latlng->lng,
            ]);

            $place->posts()->save($post);

        } catch (\Exception $e) { }

        dispatch(new SyndicatePost($post));

        return redirect()->route('post.show', [$user, $uuid]);
    }

    public function delete(Request $request)
    {
        $post = Post::findOrFail($request->get('post'));

        $post->delete();

        return redirect()->to('/home');
    }
}
