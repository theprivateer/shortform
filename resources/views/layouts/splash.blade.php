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
    <link rel="stylesheet" href="/css/splash.css">
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
        @yield('content')
    </div>

    @section('scripts')
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @show
</body>
</html>
