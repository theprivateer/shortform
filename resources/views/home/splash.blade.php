@extends('layouts.splash')

@section('content')
<div class="splash">

    <div class="content">
        <h1 class="logo">Shortform</h1>

        <ul class="list-inline">
            @if (Route::has('login'))
            <li><a href="{{ url('/login') }}">Login</a></li>
            @if(config('vault.registrations'))
            <li><a href="{{ url('/register') }}">Register</a></li>
            @endif
            @endif
            {{--<li><a href="https://github.com/theprivateer/shortform">GitHub</a></li>--}}
        </ul>

    </div>

</div>

<div class="container">

</div>
@endsection