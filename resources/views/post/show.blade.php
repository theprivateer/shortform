@extends('layouts.app')

@section('content')
    <div class="container">
        @include('post.partials.post', ['hide_identity' => ! config('shortform.user-timelines')])
    </div>
@endsection