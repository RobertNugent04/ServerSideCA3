<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://kit.fontawesome.com/2d3df2f795.js" crossorigin="anonymous"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <div class="video-background">
            <div class="dark-overlay">
                <header class="pt-6">
                    <div class="container mx-auto flex justify-start items-center px-6 space-x-4">
                        <div class="flex items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-2" height="70" width="70">
                            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                                RobPat
                            </a>
                        </div>
                        <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                            <a class="no-underline hover:underline" href="/">Home</a>
                            <a class="no-underline hover:underline" href="/movies">Movies</a>
                        </nav>
                    </div>
                </header>
                <div>
                    @yield('content')
                </div>
            </div>
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                <source src="{{ asset('videos/back.mp4') }}" type="video/mp4">
            </video>
        </div>
    </div>
</body>
</html>
