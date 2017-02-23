@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="page-header">{{ $page->getTitle() }}</h1>

            {!! $page->getBody() !!}
        </div>
    </div>
</div>

@endsection