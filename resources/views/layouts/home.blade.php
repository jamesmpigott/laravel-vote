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
        <link href="https://fonts.googleapis.com/css2?family=Asar&family=Raleway:wght@400;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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
                            @if(!Auth::user())
                                <span class="font-serif text-4xl block text-left mb-4">{{ __("Get Started") }}</span>

                                <button class="block my-4 text-sm text-gray-700" id="hideRegistration">{{ __("Already have an account? Login") }}</button>

                                <div id="register">
                                    @include('auth.register')
                                </div>

                                <div id="login" class="hidden">
                                    @include('auth.login')
                                </div>

                                <a href="{{ route('oauth.login', 'github') }}"
                                    class="mt-4 text-center rounded-lg font-medium text-sm flex items-center justify-center p-2 bg-[#24292f] text-white">
                                    <img src="{{ asset('images/GitHub-Mark-Light-32px.png') }}" 
                                        class="mr-2"
                                        width="24"
                                        height="24">
                                    {{ __('Login with Github') }}
                                </a>

                                <a href="{{ route('oauth.login', 'google') }}" 
                                    class="mt-4 flex items-center justify-center w-full px-4 py-2 text-sm text-white text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-6 h-6 mr-2" viewBox="0 0 48 48">
                                        <defs>
                                            <path id="a" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"></path>
                                        </defs>
                                        <clipPath id="b">
                                            <use xlink:href="#a" overflow="visible"></use>
                                        </clipPath>
                                        <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z"></path>
                                        <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z"></path>
                                        <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z"></path>
                                        <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z"></path>
                                    </svg>
                                    {{ __('Login with Google') }}
                                </a>
                            @else
                                <div class="flex justify-start items-center gap-x-8">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" class="w-16 h-16 rounded-full">
                                    @endif
                                    <span class="font-serif text-2xl">
                                        {{ __("Hi, :name", ['name' => Auth::user()->name]) }} 
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

