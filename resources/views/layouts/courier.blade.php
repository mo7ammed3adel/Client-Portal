<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b1f3a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="طلبة كابتن">

    <title>{{ $title ? $title.' · طلبة كابتن' : 'طلبة · تطبيق المندوب' }}</title>

    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon.svg">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-800">
    <div class="mx-auto flex min-h-screen max-w-md flex-col bg-slate-50 shadow-xl">
        {{-- Top bar --}}
        <header class="sticky top-0 z-40 flex items-center justify-between bg-ink-900 px-4 py-3 text-white">
            <a href="{{ route('courier.dashboard') }}" class="flex items-center gap-2">
                <x-brand-logo chip class="h-9 w-auto" />
                <div class="leading-tight">
                    <p class="text-base font-black">طلبة كابتن</p>
                    <p class="text-[11px] text-slate-300">{{ auth()->user()->name }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-lg bg-white/10 px-3 py-1.5 text-xs font-bold hover:bg-white/20">خروج</button>
            </form>
        </header>

        <main class="flex-1 px-4 py-5">
            @if (session('status'))
                <div class="mb-4 flex items-start gap-2 rounded-2xl border border-brand-200 bg-brand-50 p-3.5 text-sm font-semibold text-brand-800">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="px-4 pb-6 pt-2 text-center text-[11px] text-slate-400">
            طلبة · تطبيق المندوب
        </footer>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
