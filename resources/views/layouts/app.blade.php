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
        <link href="https://fonts.googleapis.com/css2?family=Asar&family=Raleway:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('messages.js') }}" defer></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased selection:bg-violet-300">
        <div class="min-h-screen flex flex-col items-center justify-center bg-center bg-cover relative" 
            style="background-color: #8EC5FC;background-image: linear-gradient({{ mt_rand(0,360)}}deg, #8EC5FC 0%, #E0C3FC 100%);"
        >
            <main id="app" class="container mt-12 md:mt-20 lg:mt-24 pb-8 px-4 lg:px-0">
                <header class="w-full pt-4 absolute top-0 left-0 text-center flex justify-center items-center">
                    <locale-switcher />
                </header>

                @yield('content')

            </main>

        </div>
    </body>
</html>

