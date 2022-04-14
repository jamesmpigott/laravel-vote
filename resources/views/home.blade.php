@extends('layouts.app')

@section('meta')
    <title>{{ __("generic.site-title") . ' | ' . __("generic.tagline") }}</title>
@endsection

@section('content')
<main id="app">
    <div class="container flex flex-wrap md:flex-nowrap justify-between md:gap-8 md:items-center lg:items-start">
        <div class="w-full lg:w-5/12 text-left">
            <h1 class="text-9xl font-light tracking-tight font-serif">{{ __("generic.site-title") }}</h1>

            <p class="block mt-8 text-xl font-medium">{{ __("generic.tagline") }}</p>
        </div>
        <div class="w-full mt-10 md:mt-0 lg:w-5/12 xl:w-4/12">
            <div class="bg-white rounded-lg p-8 drop-shadow-xl">
                @if(!Auth::user())
                    <span class="font-serif text-4xl block text-left mb-4">{{ __("generic.get-started") }}</span>

                    <button class="block my-4 text-sm text-gray-700" id="hideRegistration">
                        {{ __("generic.have-account") }}
                        <span class="underline pointer-events-none">{{ __("generic.login") }}</span>
                    </button>

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
                        {{ __("generic.login-with", ['driver' => 'Github']) }}
                    </a>

                    <a href="{{ route('oauth.login', 'google') }}" 
                        class="mt-4 flex items-center justify-center w-full px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500">
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
                        {{ __("generic.login-with", ['driver' => 'Google']) }}
                    </a>
                @else
                    <div class="flex justify-start items-center gap-x-8">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" class="w-16 h-16 rounded-full">
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="font-serif text-2xl">
                                {{ __("generic.greeting", ['name' => Auth::user()->name]) }} 
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="ml-4 mb-0 flex items-center">
                                @csrf
                                @method('POST')
                                <button class="text-xs text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <x-button type="button" class="mt-8 w-full" @click="setModalTitle('{{ __('poll-builder.title') }}');showModal(); currentModalComponent = 'poll-builder';">{{ __("poll-builder.build-poll") }}</x-button>

                    <user-polls></user-polls>
                @endif
            </div>
        </div>
    </div>
    @if(Auth::user())
        <modal>
            {{-- <template v-slot:title>
                {{ __("Let's build a poll!") }}
            </template> --}}

            <template v-slot:body>
                <component v-bind:is="switchModalComponent" :props="subdata"></component>
                {{-- <poll-builder></poll-builder> --}}
            </template>
        </modal>

    @endif
</main>
@endsection
