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
        <link href="https://fonts.googleapis.com/css2?family=Asar&family=Nunito:wght@400;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center bg-center bg-cover" style="background-image: url(https://tailwindcss.com/_next/static/media/hero@75.4dea7abe609fc522c039fba7662ceea2.jpg);">
            <!-- Page Content -->
            <main id="app">
                <div class="container flex justify-between">
                    <div class="w-full lg:w-5/12 text-left">
                        <h1 class="text-9xl font-light tracking-tight font-serif">{{ __("Super Simple Polls") }}</h1>

                        <p class="block mt-8 text-xl">{{ __("Build beautiful polls, with none of the fuss.") }}</p>
                    </div>
                    <div class="w-full lg:w-5/12">
                        <div class="bg-white rounded-lg p-8 drop-shadow-xl">
                            <span class="font-serif text-4xl block text-left mb-4">{{ __("Get Started") }}</span>

                            <button class="block my-4 text-sm text-gray-700" id="hideRegistration">{{ __("Already have an account? Login") }}</button>

                            <div id="register">
                                @include('auth.register')
                            </div>
                            <div id="login" class="hidden">
                                @include('auth.login')
                            </div>

                            <a href="{{ route('github.login') }}"
                                class="mt-4 text-center rounded-lg font-medium text-sm flex items-center justify-center p-2 bg-[#24292f] text-white">
                                <img src="{{ asset('images/GitHub-Mark-Light-32px.png') }}" 
                                    class="mr-2"
                                    width="24"
                                    height="24">
                                {{ __('Login with Github') }}
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

