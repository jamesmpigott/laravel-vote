<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex">
        
        @yield('meta')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Asar&family=Nunito:wght@400;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-serif antialiased">
        <div class="min-h-screen bg-gradient-to-r from-yellow-200 via-pink-200 to-pink-400 flex items-center justify-center">
            <!-- Page Content -->
            <main id="app">
                <div class="container text-center">
                    <h1 class="text-6xl font-light">Super Simple Polls</h1>
                </div>
            </main>
        </div>
    </body>
</html>

