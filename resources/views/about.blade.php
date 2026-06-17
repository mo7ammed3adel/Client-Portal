<x-public-layout title="من نحن">
    {{-- Header --}}
    <section class="relative overflow-hidden bg-ink-900 py-20 text-white">
        <div class="absolute -right-24 -top-20 h-80 w-80 rounded-full bg-brand-500/20 blur-3xl animate-float-slow"></div>
        <div class="section relative text-center">
            <span class="chip mx-auto border-white/15 bg-white/10 text-brand-200">من نحن</span>
            <h1 class="mt-5 text-4xl font-black sm:text-5xl">تعرّف على مكتب طلبة</h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">{{ $content['about_intro'] }}</p>
        </div>
    </section>

    {{-- Vision & Mission --}}
    <section class="bg-white py-20">
        <div class="section grid gap-6 lg:grid-cols-2">
            <div class="reveal rounded-3xl border border-slate-100 bg-slate-50/60 p-8">
                <div class="grid h-14 w-14 place-items-center rounded-2xl bg-brand-600 text-white shadow-lg shadow-brand-600/30">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </div>
                <h2 class="mt-5 text-2xl font-black text-ink-900">رؤيتنا</h2>
                <p class="mt-3 text-lg leading-8 text-slate-600">{{ $content['about_vision'] }}</p>
            </div>
            <div class="reveal rounded-3xl border border-slate-100 bg-slate-50/60 p-8" style="transition-delay:100ms">
                <div class="grid h-14 w-14 place-items-center rounded-2xl bg-ink-900 text-white shadow-lg">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                </div>
                <h2 class="mt-5 text-2xl font-black text-ink-900">رسالتنا</h2>
                <p class="mt-3 text-lg leading-8 text-slate-600">{{ $content['about_mission'] }}</p>
            </div>
        </div>
    </section>

    {{-- Terms of cooperation --}}
    <section class="bg-slate-50 py-20">
        <div class="section grid items-start gap-12 lg:grid-cols-2">
            <div class="reveal">
                <span class="chip">شروط التعاون</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">قواعد واضحة لتعامل مريح</h2>
                <p class="mt-4 text-lg leading-8 text-slate-500">نلتزم بالشفافية الكاملة مع عملائنا. هذه أهم شروط التعامل مع منصة طلبة.</p>
            </div>
            <div class="reveal rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
                <div class="space-y-3 text-lg leading-9 text-slate-700">
                    {!! nl2br(e($content['about_terms'])) !!}
                </div>
            </div>
        </div>
    </section>

    {{-- Business info --}}
    <section class="bg-white py-20">
        <div class="section">
            <div class="reveal mx-auto max-w-2xl text-center">
                <span class="chip">بيانات المكتب</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">معلومات التواصل الرسمية</h2>
            </div>
            <div class="mx-auto mt-12 grid max-w-4xl gap-6 sm:grid-cols-3">
                @php
                    $info = [
                        ['l' => 'الهاتف', 'v' => $content['about_phone'], 'dir' => 'ltr', 'i' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z'],
                        ['l' => 'البريد الإلكتروني', 'v' => $content['about_email'], 'dir' => 'ltr', 'i' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75'],
                        ['l' => 'العنوان', 'v' => $content['contact_address'], 'dir' => 'rtl', 'i' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
                    ];
                @endphp
                @foreach ($info as $i => $item)
                    <div class="reveal rounded-2xl border border-slate-100 bg-slate-50/60 p-6 text-center" style="transition-delay:{{ $i * 80 }}ms">
                        <div class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-brand-100 text-brand-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['i'] }}"/></svg>
                        </div>
                        <p class="mt-4 text-sm text-slate-400">{{ $item['l'] }}</p>
                        <p class="mt-1 font-bold text-ink-900" dir="{{ $item['dir'] }}">{{ $item['v'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('order.create') }}" class="btn-brand px-8 py-3.5 text-base">ابدأ أول شحنة مع طلبة</a>
            </div>
        </div>
    </section>
</x-public-layout>
