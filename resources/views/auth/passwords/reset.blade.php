@extends('layouts.app')

@section('meta')
    <title>{{ __("Super Simple Polls") . ' | ' . __("Build beautiful polls, with none of the fuss.") }}</title>
@endsection

@section('content')
<main id="app" class="mx-4 bg-white w-full p-8 max-w-[90%] md:max-w-[550px] lg:max-w-[40%] md:mx-auto rounded-lg shadow-md">
    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-y-4">
        @csrf
        @method('POST')
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="flex flex-col">
            <x-label for="email">{{ __('Email Address') }}</x-label>

            <x-input id="email"
                type="email"
                name="email"
                value="{{ $email ?? old('email') }}"
                required
                autocomplete="email" />
            
                @error('email')
                    <span class="text-sm text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>

        <div class="flex flex-col">
            <x-label for="password">{{ __('Password') }}</x-label>
            
            <x-input 
                id="password"
                type="password"
                name="password"
                required 
                autocomplete="new-password"/>
                
            @error('password')
                <span class="text-sm text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="flex flex-col">
            <x-label for="password-confirm">{{ __('Confirm Password') }}</x-label>
            
            <x-input 
                id="password-confirm"
                type="password"
                name="password_confirmation"
                required 
                autocomplete="new-password"/>
                
            @error('password')
                <span class="text-sm text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <x-button type="submit">{{ __('Reset Password') }}</x-button>

    </form>
</main>
@endsection