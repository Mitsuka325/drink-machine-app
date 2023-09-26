<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body style="padding: 60px 0;">
    <div id="app">
        @include('layouts.header')

        <main class="py-4">
            <div class="container">
                @if(session('flash_message'))
                <div class="alert alert-success">
                    {{session('flash_message')}}
                </div>
                @endif
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
   
    </div>
</body>
</html>
