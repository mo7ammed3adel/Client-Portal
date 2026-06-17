<x-public-layout>
    {{-- ======================= HERO ======================= --}}
    <section class="relative overflow-hidden bg-ink-900">
        <div class="absolute inset-0">
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-brand-500/20 blur-3xl animate-float-slow"></div>
            <div class="absolute -left-32 top-40 h-96 w-96 rounded-full bg-brand-400/10 blur-3xl animate-float"></div>
            <div class="absolute inset-0 opacity-[0.06]" style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
        </div>

        <div class="section relative grid items-center gap-12 py-20 lg:grid-cols-2 lg:py-28">
            <div class="text-center lg:text-right">
                <span class="chip animate-fade-in border-white/15 bg-white/10 text-brand-200">
                    <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-brand-400"></span></span>
                    شحن وتوصيل في نفس اليوم
                </span>

                <h1 class="mt-6 animate-fade-up text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                    اشحن أي حاجة،
                    <span class="bg-gradient-to-l from-brand-300 to-brand-500 bg-clip-text text-transparent">في كل أنحاء</span>
                    الدقهلية
                </h1>

                <p class="mx-auto mt-6 max-w-xl animate-fade-up text-lg leading-8 text-slate-300 lg:mx-0" style="animation-delay:.1s">
                    مكتب طلبة للشحن والتوصيل الداخلي في محافظة الدقهلية. حدّد موقع الاستلام والتسليم على الخريطة،
                    واحسب التكلفة فورًا حسب المسافة، وادفع أونلاين بأمان — شحنتك تتحرك في دقائق بدون عقود ولا اشتراكات.
                </p>

                <div class="mt-9 flex animate-fade-up flex-col items-center gap-3 sm:flex-row lg:justify-start" style="animation-delay:.2s">
                    <a href="{{ route('order.create') }}" class="btn-brand w-full px-7 py-3.5 text-base sm:w-auto">
                        اطلب توصيل الآن
                        <svg class="h-5 w-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                    <a href="{{ route('order.track') }}" class="btn-light w-full px-7 py-3.5 text-base sm:w-auto">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75 21 21m-3.75-9a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" /></svg>
                        تتبع شحنتك
                    </a>
                </div>

                <div class="mt-12 grid grid-cols-3 gap-4 border-t border-white/10 pt-8 text-center lg:text-right">
                    <div><p class="text-3xl font-black text-white" data-count="98">0</p><p class="mt-1 text-xs text-slate-400">% طلبات في الموعد</p></div>
                    <div><p class="text-3xl font-black text-white" data-count="18">0</p><p class="mt-1 text-xs text-slate-400">مركز ومدينة بالدقهلية</p></div>
                    <div><p class="text-3xl font-black text-white" data-count="20">0</p><p class="mt-1 text-xs text-slate-400">جنيه يبدأ منها التوصيل</p></div>
                </div>
            </div>

            {{-- Animated delivery illustration --}}
            <div class="relative animate-fade-in" style="animation-delay:.15s">
                @include('partials.illustrations.hero-scooter')
            </div>
        </div>

        <div class="relative overflow-hidden border-t border-white/10 py-4">
            <div class="flex w-max animate-marquee items-center gap-12 whitespace-nowrap text-sm font-bold text-slate-400">
                @foreach (['دفع إلكتروني آمن', 'تتبع لحظي للشحنة', 'تسعير شفاف بالكيلومتر', 'استلام من الباب', 'دعم على مدار الساعة', 'تغطية كل مراكز الدقهلية'] as $item)
                    @for ($i = 0; $i < 2; $i++)
                        <span class="flex items-center gap-12"><span class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>{{ $item }}</span></span>
                    @endfor
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================= HOW IT WORKS ======================= --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="section">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="chip">كيف تطلب؟</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">أربع خطوات بسيطة وشحنتك في الطريق</h2>
                <p class="mt-4 text-lg text-slate-500">من تحديد الموقع حتى التسليم — كل حاجة أونلاين وبدون تعقيد.</p>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $steps = [
                        ['n' => '01', 'title' => 'حدّد الموقعين', 'desc' => 'اختر نقطة الاستلام والتسليم على الخريطة بسهولة.', 'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
                        ['n' => '02', 'title' => 'احسب التكلفة', 'desc' => 'نحسب المسافة والتكلفة تلقائيًا وبشفافية كاملة.', 'icon' => 'M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008ZM9.75 15.75v2.25M9 21h6a2.25 2.25 0 0 0 2.25-2.25V5.25A2.25 2.25 0 0 0 15 3H9a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 9 21Z'],
                        ['n' => '03', 'title' => 'ادفع أونلاين', 'desc' => 'ادفع بالكارت أو المحفظة بأمان عبر بوابة موثوقة.', 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z'],
                        ['n' => '04', 'title' => 'تتبع شحنتك', 'desc' => 'تابع حالة الطلب لحظة بلحظة حتى الوصول.', 'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z'],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="reveal group relative rounded-2xl border border-slate-100 bg-slate-50/60 p-6 transition hover:-translate-y-1 hover:border-brand-200 hover:bg-white hover:shadow-xl hover:shadow-brand-600/5" style="transition-delay:{{ $i * 80 }}ms">
                        <span class="absolute left-5 top-5 text-4xl font-black text-slate-100 transition group-hover:text-brand-100">{{ $step['n'] }}</span>
                        <div class="relative grid h-12 w-12 place-items-center rounded-xl bg-brand-600 text-white shadow-lg shadow-brand-600/30">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" /></svg>
                        </div>
                        <h3 class="relative mt-5 text-lg font-black text-ink-900">{{ $step['title'] }}</h3>
                        <p class="relative mt-2 text-sm leading-7 text-slate-500">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================= FEATURES ======================= --}}
    <section class="bg-slate-50 py-20 lg:py-24">
        <div class="section">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="reveal">
                    <span class="chip">ليه طلبة؟</span>
                    <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">خدمة توصيل تثق فيها</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-500">
                        بنوصّل شحناتك بسرعة وأمان وبأسعار عادلة محسوبة بدقة. التزام بالمواعيد، تتبع كامل، ودعم دائم.
                    </p>

                    <div class="mt-8 grid gap-5 sm:grid-cols-2">
                        @php
                            $features = [
                                ['t' => 'سرعة في التوصيل', 'd' => 'كباتن في كل مكان لاستلام شحنتك فورًا.', 'i' => 'm3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z'],
                                ['t' => 'أمان وحماية', 'd' => 'شحنتك مؤمّنة ومتابَعة حتى التسليم.', 'i' => 'M9 12.75 11.25 15 15 9.75M21 12c0 5.25-3.5 9-9 9.75C6.5 21 3 17.25 3 12V5.25l9-2.25 9 2.25V12Z'],
                                ['t' => 'تسعير شفاف', 'd' => 'تعرف التكلفة بالكيلومتر قبل ما تدفع.', 'i' => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                                ['t' => 'تتبع لحظي', 'd' => 'تابع رحلة شحنتك خطوة بخطوة.', 'i' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25'],
                            ];
                        @endphp
                        @foreach ($features as $f)
                            <div class="reveal flex gap-4">
                                <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-100 text-brand-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['i'] }}" /></svg>
                                </div>
                                <div>
                                    <h3 class="font-black text-ink-900">{{ $f['t'] }}</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-500">{{ $f['d'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal relative">
                    <div class="relative mx-auto max-w-md">
                        <div class="absolute -inset-4 rounded-[2.5rem] bg-brand-500/10 blur-2xl"></div>
                        <div class="absolute -right-4 -top-4 hex h-20 w-20 bg-accent-500/15"></div>
                        <div class="relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white p-8 shadow-2xl shadow-ink-900/5">
                            @include('partials.illustrations.scooter')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================= PRICING ======================= --}}
    <section class="relative overflow-hidden bg-ink-900 py-20 text-white lg:py-24">
        <div class="absolute -right-20 top-10 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
        <div class="section relative grid items-center gap-12 lg:grid-cols-2">
            <div class="reveal">
                <span class="chip border-white/15 bg-white/10 text-brand-200">تسعير عادل</span>
                <h2 class="mt-4 text-3xl font-black sm:text-4xl">تدفع حسب المسافة فقط</h2>
                <p class="mt-4 text-lg leading-8 text-slate-300">
                    بدون رسوم خفية. التكلفة بتتحسب تلقائيًا من المسافة بين نقطة الاستلام والتسليم — تشوفها قبل ما تدفع.
                </p>
                <ul class="mt-6 space-y-3 text-slate-200">
                    <li class="flex items-center gap-3"><svg class="h-5 w-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> حساب فوري للتكلفة على الخريطة</li>
                    <li class="flex items-center gap-3"><svg class="h-5 w-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> بدون عقود أو حد أدنى للطلبات</li>
                    <li class="flex items-center gap-3"><svg class="h-5 w-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> ملخص واضح للتكلفة قبل الدفع</li>
                </ul>
            </div>

            <div class="reveal">
                @php
                    $hBase = rtrim(rtrim(number_format($baseFee, 2), '0'), '.');
                    $hBaseKm = rtrim(rtrim(number_format($baseDistanceKm, 2), '0'), '.');
                    $hRate = rtrim(rtrim(number_format($costPerKm, 2), '0'), '.');
                    $exampleTotal = $baseFee + max(0, 12 - $baseDistanceKm) * $costPerKm;
                @endphp
                <div class="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur">
                    <p class="text-sm font-bold text-brand-300">سعر التوصيل يبدأ من</p>
                    <div class="mt-2 flex items-end gap-2">
                        <span class="text-6xl font-black">{{ $hBase }}</span>
                        <span class="mb-2 text-xl font-bold text-slate-300">جنيه لأول {{ $hBaseKm }} كم</span>
                    </div>
                    <div class="mt-6 space-y-3 rounded-2xl bg-ink-800/60 p-5 text-sm">
                        <div class="flex items-center justify-between text-slate-300"><span>أول {{ $hBaseKm }} كم</span><span class="font-bold text-white">{{ $hBase }} جنيه</span></div>
                        <div class="flex items-center justify-between text-slate-300"><span>كل كم إضافي</span><span class="font-bold text-white">{{ $hRate }} جنيه</span></div>
                        <div class="my-2 border-t border-white/10"></div>
                        <div class="flex items-center justify-between text-base"><span class="font-bold text-brand-300">مثال: 12 كم</span><span class="text-2xl font-black text-white">{{ number_format($exampleTotal) }} جنيه</span></div>
                    </div>
                    <a href="{{ route('order.create') }}" class="btn-brand mt-6 w-full justify-center py-3.5 text-base">احسب تكلفتك واطلب الآن</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================= SERVICES ======================= --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="section">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="chip">خدماتنا</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">نوصّل كل أنواع الشحنات</h2>
            </div>
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $services = [
                        ['t' => 'مستندات وأوراق', 'd' => 'توصيل سريع وآمن للمستندات الهامة.'],
                        ['t' => 'طرود وهدايا', 'd' => 'إرسال الطرود والهدايا لأي عنوان.'],
                        ['t' => 'شحنات المتاجر', 'd' => 'حلول توصيل للمتاجر الإلكترونية والطلبات.'],
                        ['t' => 'شحنات الشركات', 'd' => 'عروض مخصصة للكميات والشحنات المتكررة.'],
                    ];
                @endphp
                @foreach ($services as $i => $sv)
                    <div class="reveal rounded-2xl border border-slate-100 bg-gradient-to-b from-white to-slate-50 p-6 text-center transition hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-600/5" style="transition-delay:{{ $i * 80 }}ms">
                        <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-brand-600/10 text-brand-700">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m7.5 7.5-.75 11.25a.75.75 0 0 0 .75.75h9a.75.75 0 0 0 .75-.75L16.5 7.5M7.5 7.5h9M7.5 7.5 9 4.5h6l1.5 3M9.75 11.25v4.5M14.25 11.25v4.5" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-black text-ink-900">{{ $sv['t'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ $sv['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================= TRACK BAND ======================= --}}
    <section class="bg-slate-50 py-16">
        <div class="section">
            <div class="reveal overflow-hidden rounded-3xl bg-gradient-to-l from-brand-700 to-brand-500 p-8 shadow-2xl shadow-brand-600/20 sm:p-12">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <h2 class="text-2xl font-black text-white sm:text-3xl">عندك رقم تتبع؟</h2>
                        <p class="mt-2 text-brand-50">تابع شحنتك لحظة بلحظة بإدخال رقم التتبع الخاص بك.</p>
                    </div>
                    <form action="{{ route('order.track') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                        <input type="text" name="number" placeholder="مثال: TLB-260617-00001"
                               class="w-full rounded-xl border-0 px-4 py-3.5 text-ink-900 shadow-sm focus:ring-2 focus:ring-white">
                        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-ink-900 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-ink-800">
                            تتبع
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================= FINAL CTA ======================= --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="section">
            <div class="reveal mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-black text-ink-900 sm:text-4xl">جاهز ترسل شحنتك؟</h2>
                <p class="mt-4 text-lg text-slate-500">ابدأ طلبك دلوقتي — من غير حساب ولا اشتراك. خطوات بسيطة ودفع آمن.</p>
                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ route('order.create') }}" class="btn-brand px-8 py-3.5 text-base">اطلب توصيل الآن</a>
                    <a href="{{ route('contact') }}" class="btn-outline px-8 py-3.5 text-base">تواصل مع المبيعات</a>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('[data-count]');
                const run = (el) => {
                    const target = Number(el.dataset.count);
                    const duration = 1400;
                    const start = performance.now();
                    const step = (now) => {
                        const p = Math.min((now - start) / duration, 1);
                        el.textContent = Math.floor(p * target).toLocaleString('ar-EG');
                        if (p < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                };
                if ('IntersectionObserver' in window) {
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach((e) => { if (e.isIntersecting) { run(e.target); io.unobserve(e.target); } });
                    }, { threshold: 0.5 });
                    counters.forEach((c) => io.observe(c));
                } else {
                    counters.forEach(run);
                }
            });
        </script>
    @endpush
</x-public-layout>
