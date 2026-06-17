<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-lg bg-blue-600 text-sm font-black text-white">CP</div>
        <h1 class="text-2xl font-black text-slate-950 dark:text-white">Client Portal</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Access requests, billing, and delivery status.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900" name="remember">
            <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">Remember me</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-col gap-2 text-sm font-semibold sm:flex-row sm:items-center sm:gap-4">
                @if (Route::has('password.request'))
                    <a class="text-slate-500 hover:text-blue-600 dark:text-slate-400" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
                @if (Route::has('register'))
                    <a class="text-slate-500 hover:text-blue-600 dark:text-slate-400" href="{{ route('register') }}">
                        Create account
                    </a>
                @endif
            </div>

            <x-primary-button>
                Sign In
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
