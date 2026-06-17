@php($s = \App\Models\Setting::allWithDefaults())

<footer class="relative overflow-hidden bg-ink-900 text-slate-300">
    <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-brand-500/10 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2.5">
                    <x-brand-mark class="h-10 w-10" />
                    <span class="text-2xl font-black text-white">طلبة</span>
                </div>
                <p class="mt-4 text-sm leading-7 text-slate-400">
                    منصة شحن وتوصيل سريعة وموثوقة. نحسب التكلفة بشفافية حسب المسافة ونوصّل شحنتك بأمان في أسرع وقت.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-white">روابط سريعة</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-400">الرئيسية</a></li>
                    <li><a href="{{ route('order.create') }}" class="hover:text-brand-400">إنشاء طلب توصيل</a></li>
                    <li><a href="{{ route('order.track') }}" class="hover:text-brand-400">تتبع شحنة</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-brand-400">من نحن</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-brand-400">تواصل معنا</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-white">تواصل معنا</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                        <span dir="ltr">{{ $s['contact_phone'] }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        <span dir="ltr">{{ $s['contact_email'] }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                        <span>{{ $s['contact_address'] }}</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-white">للأعمال</h3>
                <p class="mt-4 text-sm leading-7 text-slate-400">
                    عندك شحنات كثيرة أو متجر إلكتروني؟ تواصل معنا لعروض الشركات والكميات.
                </p>
                <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-bold text-white hover:bg-brand-500">
                    اطلب عرض سعر
                </a>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-sm text-slate-400 sm:flex-row">
            <p>© {{ date('Y') }} طلبة. جميع الحقوق محفوظة.</p>
            <div class="flex items-center gap-4 text-xs">
                <a href="{{ route('login') }}" class="hover:text-brand-400">دخول الفريق / المناديب</a>
                <span>مدفوعات آمنة عبر Kashier</span>
            </div>
        </div>
    </div>
</footer>
