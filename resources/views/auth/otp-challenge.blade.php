<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-lg bg-blue-600 text-sm font-black text-white">CP</div>
        <h1 class="text-2xl font-black text-slate-950 dark:text-white">Enter OTP</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            We sent a 6-digit code to {{ $phone }}.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="otp" :value="__('OTP Code')" />
            <x-text-input id="otp" class="mt-1 block w-full text-center text-lg font-bold tracking-[0.35em]" type="text" inputmode="numeric" name="otp" required autofocus autocomplete="one-time-code" maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <button class="text-sm font-semibold text-slate-500 hover:text-blue-600 dark:text-slate-400" type="submit" formaction="{{ route('otp.resend') }}" formmethod="POST" formnovalidate>
                Resend code
            </button>

            <x-primary-button>
                Verify
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
