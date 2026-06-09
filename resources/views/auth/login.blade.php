<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-6 flex items-center justify-center space-x-2">
            <div class="h-px bg-gray-300 dark:bg-gray-700 flex-1"></div>
            <span class="text-xs text-gray-400 uppercase font-semibold">Or</span>
            <div class="h-px bg-gray-300 dark:bg-gray-700 flex-1"></div>
        </div>

        <div class="mt-6">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-2xl shadow-sm bg-white dark:bg-gray-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-sm font-bold text-slate-700 dark:text-slate-200 transition-all">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.58 14.99 1 12 1 7.24 1 3.2 3.65 1.13 7.55l3.96 3.07C6.07 7.55 8.78 5.04 12 5.04z"/>
                    <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.36H12v4.51h6.46c-.28 1.48-1.11 2.73-2.36 3.58v2.98h3.81c2.23-2.05 3.58-5.07 3.58-8.71z"/>
                    <path fill="#FBBC05" d="M5.09 10.62c-.24-.73-.38-1.5-.38-2.3c0-.8.14-1.57.38-2.3L1.13 2.95C.41 4.38 0 5.99 0 7.7c0 1.71.41 3.32 1.13 4.75l3.96-3.07v.24z"/>
                    <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.81-2.98c-1.06.71-2.42 1.14-4.15 1.14-3.22 0-5.93-2.51-6.91-6.03l-3.96 3.07C3.2 20.35 7.24 23 12 23z"/>
                </svg>
                <span>Continue with Google</span>
            </a>
        </div>
    </form>
</x-guest-layout>
