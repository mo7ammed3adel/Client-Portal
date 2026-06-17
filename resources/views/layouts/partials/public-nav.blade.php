@php
    $navLinks = [
        ['route' => 'home', 'label' => 'الرئيسية', 'pattern' => 'home'],
        ['route' => 'pricing', 'label' => 'الأسعار', 'pattern' => 'pricing'],
        ['route' => 'order.create', 'label' => 'إنشاء طلب', 'pattern' => 'order.create'],
        ['route' => 'order.track', 'label' => 'تتبع شحنة', 'pattern' => 'order.track'],
        ['route' => 'about', 'label' => 'من نحن', 'pattern' => 'about'],
        ['route' => 'contact', 'label' => 'تواصل معنا', 'pattern' => 'contact'],
    ];
@endphp

<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = window.scrollY > 12"
     :class="scrolled ? 'bg-white/95 shadow-md shadow-slate-900/5' : 'bg-white/80'"
     class="sticky top-0 z-50 border-b border-slate-100 backdrop-blur transition-colors duration-300">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <x-brand-logo class="h-12 w-auto" />
        </a>

        <div class="hidden items-center gap-1 lg:flex">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="rounded-lg px-3.5 py-2 text-sm font-bold transition {{ request()->routeIs($link['pattern']) ? 'text-brand-600' : 'text-slate-600 hover:bg-slate-50 hover:text-ink-900' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('order.create') }}" class="btn-brand">
                اطلب الآن
                <svg class="h-4 w-4 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>

        <button @click="open = !open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="القائمة">
            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-collapse class="border-t border-slate-100 bg-white lg:hidden">
        <div class="space-y-1 px-4 py-4">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="block rounded-lg px-4 py-2.5 text-base font-bold {{ request()->routeIs($link['pattern']) ? 'bg-brand-50 text-brand-700' : 'text-slate-700 hover:bg-slate-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('order.create') }}" class="btn-brand mt-2 w-full justify-center">اطلب الآن</a>
        </div>
    </div>
</nav>
