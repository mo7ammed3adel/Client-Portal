<x-guest-layout>
    <div class="mb-8 text-center">
        <x-brand-logo class="mx-auto mb-4 h-16 w-auto" />
        <h1 class="text-2xl font-black text-slate-950 dark:text-white">لوحة تحكم طلبة</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">تسجيل دخول فريق الإدارة لإدارة الطلبات والإعدادات.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="كلمة المرور" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-600 shadow-sm focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-900" name="remember">
            <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">تذكرني</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-col gap-2 text-sm font-semibold sm:flex-row sm:items-center sm:gap-4">
                @if (Route::has('password.request'))
                    <a class="text-slate-500 hover:text-brand-600 dark:text-slate-400" href="{{ route('password.request') }}">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>

            <x-primary-button>
                تسجيل الدخول
            </x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('home') }}" class="font-semibold text-brand-600 hover:underline">العودة إلى موقع طلبة</a>
    </p>
</x-guest-layout>
