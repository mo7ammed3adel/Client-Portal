{{-- Home hero visual: TOLBA courier holding a branded box --}}
<div class="relative mx-auto max-w-md">
    <div class="absolute inset-6 rounded-full bg-brand-500/25 blur-3xl"></div>
    <div class="absolute -right-6 top-10 hex h-24 w-24 bg-accent-500/20"></div>
    <div class="absolute -left-4 bottom-16 hex h-16 w-16 bg-brand-300/20"></div>

    <img src="{{ asset('brand/courier.png') }}" alt="مندوب طلبة يحمل شحنة"
         class="relative w-full animate-float-slow drop-shadow-2xl" width="1000" height="1000">

    {{-- floating badge: time --}}
    <div class="absolute -left-3 top-12 animate-float rounded-2xl border border-slate-100 bg-white p-3 shadow-xl sm:-left-6">
        <div class="flex items-center gap-2.5">
            <div class="grid h-9 w-9 place-items-center rounded-xl bg-brand-100 text-brand-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div><p class="text-xs text-slate-400">وقت التوصيل</p><p class="text-sm font-black text-ink-900">~ 45 دقيقة</p></div>
        </div>
    </div>

    {{-- floating badge: paid --}}
    <div class="absolute -right-2 bottom-10 animate-float-slow rounded-2xl border border-slate-100 bg-white p-3 shadow-xl sm:-right-6">
        <div class="flex items-center gap-2.5">
            <div class="grid h-9 w-9 place-items-center rounded-xl bg-accent-500 text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            <div><p class="text-xs text-slate-400">الدفع</p><p class="text-sm font-black text-ink-900">تم بنجاح</p></div>
        </div>
    </div>
</div>
