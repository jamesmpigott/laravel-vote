<form method="POST" action="{{ route('login') }}" class="flex flex-col gap-y-4">
    @csrf
    @method('POST')

    <div class="flex flex-col">
        <x-label for="email">{{ __('Email Address') }}</x-label>

        <x-input id="email" 
            type="email" 
            name="email"
            value="{{ old('email') }}"
            required
            autocomplete="email"
            autofocus />

        @error('email')
            <span class="text-sm text-red-500" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex flex-col">
        <x-label for="password">{{ __('Password') }}</x-label>

        <input id="password"
            type="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
            name="password"
            required
            autocomplete="current-password">

        @error('password')
            <span class="text-sm text-red-500" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex flex-col">
        <x-label>
            <input type="checkbox" 
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                name="remember"
                id="remember"
                {{ old('remember') ? 'checked' : '' }}>
            <span class="ml-2">{{ __('Remember Me') }}</span>
        </x-label>
    </div>

    <x-button type="submit">{{ __('Login') }}</x-button>

    @if (Route::has('password.request'))
        <a class="block mt-2 text-sm text-slate-600" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    @endif
</form>