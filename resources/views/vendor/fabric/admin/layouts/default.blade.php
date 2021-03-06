<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

@section('head')
    <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'shortform') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">

        <link rel="shortcut icon" href="/img/favicon.png">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        </script>
    @show
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}">
                    {{ config('app.name', 'shortform') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::check())
                        <li><a href="{{ route('home') }}">Home</a></li>
                    @endif
                </ul>

                {!! nav('main', 'nav navbar-nav') !!}

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @if(config('shortform.user-registration'))<li><a href="{{ route('register') }}">Register</a></li>@endif
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('user.edit') }}">Edit Profile</a>
                                </li>

                                <li>
                                    <a href="{{ route('community.publishing.edit') }}">Community Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('fabric::site.edit') }}" class="list-group-item">Site</a>
                    <a href="{{ route('fabric::page.index') }}" class="list-group-item">Pages</a>
                    <a href="{{ route('fabric::index.index') }}" class="list-group-item">Indices</a>
                </div>
            </div>

            <div class="col-md-9">
                @include('flash::message')

                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p class="text-center">Powered by <a href="https://github.com/theprivateer/shortform" target="_blank" class="shortform-credit">ShortForm</a></p>
        </div>
    </footer>
</div>

@section('scripts')
    <!-- Scripts -->
    <script src="/vendor/fabric/js/app.js"></script>
@show
</body>
</html>

