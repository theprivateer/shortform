@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1 class="page-header">{{ $place->name }}<br />
                <small>{{ $place->secondaryInfo() }}</small>
                </h1>
            </div>
        </div>

        @foreach($posts as $post)
            @include('post.partials.post')
        @endforeach

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="text-center">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection