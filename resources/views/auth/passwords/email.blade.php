@extends('layouts.app')

@section('meta')
    <title>{{ __("Super Simple Polls") . ' | ' . __("Build beautiful polls, with none of the fuss.") }}</title>
@endsection

@section('content')
<main id="app" class="mx-4 bg-white w-full p-8 max-w-[90%] md:max-w-[550px] lg:max-w-[40%] md:mx-auto rounded-lg shadow-md">
    @if(session('status'))
        <div class="mb-4 border-green-600 border-2 rounded-lg p-2.5 font-medium" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-y-4">
        @csrf
        @method('POST')
        <div class="flex flex-col">
            <x-label for="email">{{ __('Email Address') }}</x-label>

            <x-input id="email"
                type="email"
                name="email"
                value="{{ old('name') }}"
                required
                autocomplete="email" />

            @error('email')
                <span class="text-sm text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <x-button type="submit">{{ __('Send Password Reset Link') }}</x-button>

    </form>
</main>
@endsection