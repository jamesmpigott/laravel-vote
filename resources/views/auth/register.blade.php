<form method="POST" action="{{ route('register') }}" class="flex flex-col gap-y-4">
    @csrf
    @method('POST')
    <div class="flex flex-col">
        <x-label for="name">{{ __('Name') }}</x-label>

        <x-input id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            autocomplete="name"
            autofocus/>

        @error('name')
            <span class="text-sm text-red-500" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex flex-col">
        <x-label for="email">{{ __('Email Address') }}</x-label>

        <x-input id="register_email"
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

    <div class="flex flex-col">
        <x-label for="password">{{ __('Password') }}</x-label>

        <x-input id="register_password"
            type="password"
            name="password"
            required
            autocomplete="new-password" />

        @error('password')
            <span class="text-sm text-red-500" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex flex-col">
        <x-label for="password-confirm">{{ __('Confirm Password') }}</x-label>

        <x-input id="password-confirm"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"/>
    </div>

    <x-button type="submit">{{ __('Register') }}</x-button>
</form>
