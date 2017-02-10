@extends('layouts.app')

@section('content')
    <div class="container">

        @foreach($posts as $post)
            @include('post.partials.post')
        @endforeach

        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="text-center">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection