<x-public-layout title="الأسعار">
    @php
        $rate = rtrim(rtrim(number_format($costPerKm, 2), '0'), '.');
        $base = rtrim(rtrim(number_format($baseFee, 2), '0'), '.');
        $baseKm = rtrim(rtrim(number_format($baseDistanceKm, 2), '0'), '.');
        $examples = [2, 4, 6, 8, 12, 20];
    @endphp

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden bg-brand-50">
        {{-- hexagon decorations --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="hex absolute -left-10 top-10 h-40 w-40 bg-brand-200/50"></div>
            <div class="hex absolute right-1/3 -top-8 h-24 w-24 bg-accent-200/40"></div>
            <div class="hex absolute bottom-6 left-1/4 h-16 w-16 bg-brand-300/40"></div>
        </div>

        <div class="section relative grid items-center gap-10 py-16 lg:grid-cols-2 lg:py-24">
            <div class="text-center lg:text-right">
                <span class="chip animate-fade-in">تسعير شفاف 100%</span>
                <h1 class="heading-xl mt-5 animate-fade-up">
                    اشحن أكتر،
                    <span class="text-accent-600">وادفع أقل</span>
                </h1>
                <p class="mx-auto mt-5 max-w-xl animate-fade-up text-lg leading-8 text-slate-600 lg:mx-0" style="animation-delay:.1s">
                    شحن داخلي سريع في كل مراكز ومدن الدقهلية. السعر يبدأ بـ {{ $base }} جنيه لأول {{ $baseKm }} كم،
                    ثم {{ $rate }} جنيه لكل كيلومتر إضافي — بدون رسوم خفية ولا عقود.
                </p>
                <div class="mt-8 flex animate-fade-up flex-col items-center gap-3 sm:flex-row lg:justify-start" style="animation-delay:.2s">
                    <a href="{{ route('order.create') }}" class="btn-brand px-7 py-3.5 text-base">
                        ابدأ طلبك الآن
                        <svg class="h-5 w-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#calculator" class="btn-outline px-7 py-3.5 text-base">احسب التكلفة</a>
                </div>
                <div class="mt-8 flex items-center justify-center gap-2 text-sm font-bold text-brand-700 lg:justify-start">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    {{ $base }} جنيه لأول {{ $baseKm }} كم · شحن داخل الدقهلية فقط
                </div>
            </div>

            <div class="relative animate-fade-in">
                @include('partials.illustrations.delivery-truck')
            </div>
        </div>
    </section>

    {{-- ===================== INSTANT PRICING + CALCULATOR ===================== --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="section grid items-center gap-12 lg:grid-cols-2">
            {{-- features --}}
            <div class="reveal">
                <span class="chip">الدفع بشكل فوري</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">تسعير عادل ومفهوم</h2>
                <p class="mt-4 text-lg leading-8 text-slate-500">
                    مفيش مفاجآت. التكلفة بتظهر لك على الخريطة قبل الدفع، وكل جنيه له سبب واضح.
                </p>
                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    @php
                        $feats = [
                            ['t' => 'حساب بالكيلومتر', 'd' => 'التكلفة من المسافة الفعلية بين النقطتين.', 'i' => 'M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008ZM9.75 15.75v2.25M9 21h6a2.25 2.25 0 0 0 2.25-2.25V5.25A2.25 2.25 0 0 0 15 3H9a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 9 21Z'],
                            ['t' => 'بدون رسوم خفية', 'd' => 'تشوف الإجمالي كامل قبل ما تدفع.', 'i' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                            ['t' => 'بدون عقود', 'd' => 'ادفع لكل شحنة على حدة، بدون اشتراك.', 'i' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'],
                            ['t' => 'دفع إلكتروني آمن', 'd' => 'بطاقة أو محفظة عبر بوابة موثوقة.', 'i' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z'],
                        ];
                    @endphp
                    @foreach ($feats as $f)
                        <div class="flex gap-4">
                            <div class="hex grid h-12 w-12 shrink-0 place-items-center bg-brand-100 text-brand-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['i'] }}"/></svg>
                            </div>
                            <div>
                                <h3 class="font-black text-ink-900">{{ $f['t'] }}</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-500">{{ $f['d'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- calculator --}}
            <div id="calculator" class="reveal">
                <div class="relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl shadow-slate-900/10 sm:p-8"
                     data-cost-per-km="{{ $costPerKm }}" data-base-fee="{{ $baseFee }}" data-base-distance="{{ $baseDistanceKm }}" data-min-cost="{{ $minOrderCost }}" id="calc">
                    <div class="hex absolute -right-8 -top-8 h-28 w-28 bg-brand-50"></div>
                    <div class="relative">
                        <h3 class="text-xl font-black text-ink-900">احسب تكلفة شحنتك</h3>
                        <p class="mt-1 text-sm text-slate-500">حرّك المؤشر أو اكتب المسافة لمعرفة السعر التقريبي.</p>

                        <div class="mt-6">
                            <div class="flex items-end justify-between">
                                <label for="calc-km" class="field-label">المسافة (كيلومتر)</label>
                                <span class="text-2xl font-black text-brand-600"><span id="calc-km-label">10</span> كم</span>
                            </div>
                            <input id="calc-km" type="range" min="1" max="100" value="10" step="1"
                                   class="mt-3 w-full accent-brand-600">
                            <div class="mt-2 flex justify-between text-xs text-slate-400"><span>1 كم</span><span>100 كم</span></div>
                        </div>

                        <div class="mt-6 space-y-2.5 rounded-2xl bg-brand-50 p-5 text-sm">
                            <div class="flex items-center justify-between text-slate-600"><span>أول {{ $baseKm }} كم</span><span class="font-bold text-ink-900">{{ $base }} جنيه</span></div>
                            <div class="flex items-center justify-between text-slate-600"><span>كل كم إضافي</span><span class="font-bold text-ink-900">{{ $rate }} جنيه</span></div>
                            <div class="my-1 border-t border-brand-200"></div>
                            <div class="flex items-center justify-between"><span class="text-base font-black text-accent-600">الإجمالي التقريبي</span><span class="text-3xl font-black text-accent-600"><span id="calc-total">20</span> ج</span></div>
                        </div>

                        <a href="{{ route('order.create') }}" class="btn-brand mt-6 w-full justify-center py-3.5 text-base">اطلب الآن واحسبها بدقة على الخريطة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== PRICING TABLE ===================== --}}
    <section class="bg-brand-50 py-20 lg:py-24">
        <div class="section">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="chip">خطة التسعير</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">أمثلة للأسعار حسب المسافة</h2>
                <p class="mt-4 text-lg text-slate-500">السعر النهائي يُحسب بدقة من موقعك على الخريطة. الأرقام التالية للتوضيح فقط.</p>
            </div>

            <div class="reveal mx-auto mt-12 max-w-3xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-900/5">
                <table class="w-full text-center">
                    <thead>
                        <tr class="border-b border-slate-100 bg-ink-900 text-white">
                            <th class="px-4 py-4 text-sm font-black">المسافة</th>
                            <th class="px-4 py-4 text-sm font-black">طريقة الحساب</th>
                            <th class="px-4 py-4 text-sm font-black">الإجمالي التقريبي</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($examples as $km)
                            @php
                                $extra = max(0, $km - $baseDistanceKm);
                                $total = max($baseFee + $extra * $costPerKm, $minOrderCost);
                                $popular = $km === 6;
                                $calc = $extra > 0
                                    ? $base.'ج + '.rtrim(rtrim(number_format($extra,2),'0'),'.').'كم × '.$rate.'ج'
                                    : $base.'ج (ضمن أول '.$baseKm.' كم)';
                            @endphp
                            <tr class="{{ $popular ? 'bg-brand-50/70' : '' }}">
                                <td class="px-4 py-4 font-bold text-ink-900">
                                    {{ $km }} كم
                                    @if ($popular)<span class="ms-2 rounded-full bg-accent-600 px-2 py-0.5 text-[11px] font-bold text-white">الأكثر طلبًا</span>@endif
                                </td>
                                <td class="px-4 py-4 text-xs text-slate-500" dir="rtl">{{ $calc }}</td>
                                <td class="px-4 py-4 text-lg font-black {{ $popular ? 'text-accent-600' : 'text-brand-700' }}">{{ number_format($total) }} ج</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ===================== FAQ ===================== --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="section max-w-3xl">
            <div class="text-center reveal">
                <span class="chip">الأسئلة الشائعة</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">عندك سؤال عن الأسعار؟</h2>
            </div>

            <div class="mt-10 space-y-3" x-data="{ open: 1 }">
                @php
                    $faqs = [
                        ['q' => 'إزاي بتتحسب تكلفة الشحن؟', 'a' => 'التكلفة '.$base.' جنيه لأول '.$baseKm.' كيلومتر، ثم '.$rate.' جنيه عن كل كيلومتر إضافي. بنقيس المسافة بين نقطة الاستلام ونقطة التسليم على الخريطة، والسعر بيظهر لك قبل الدفع.'],
                        ['q' => 'إيه نطاق الخدمة؟', 'a' => 'مكتب طلبة بيخدم الشحن الداخلي داخل محافظة الدقهلية فقط (بلقاس وكل مراكز ومدن المحافظة). لا نوفّر شحنًا خارج المحافظة أو شحنًا دوليًا.'],
                        ['q' => 'هل فيه رسوم خفية؟', 'a' => 'لا. التكلفة بتظهر لك كاملة قبل الدفع'.($minOrderCost > 0 ? '، مع حد أدنى للطلب قدره '.rtrim(rtrim(number_format($minOrderCost,2),'0'),'.').' جنيه.' : ' وبدون أي رسوم إضافية.')],
                        ['q' => 'إمتى يتأكد الطلب؟', 'a' => 'الطلب بيتأكد بعد إتمام الدفع الإلكتروني بنجاح فقط، وساعتها بيتولد رقم تتبع فريد لشحنتك.'],
                        ['q' => 'إيه طرق الدفع المتاحة؟', 'a' => 'الدفع الإلكتروني بالبطاقة البنكية أو المحفظة الإلكترونية عبر بوابة دفع آمنة بالجنيه المصري.'],
                    ];
                @endphp
                @foreach ($faqs as $i => $faq)
                    <div class="reveal overflow-hidden rounded-2xl border border-slate-100">
                        <button type="button" @click="open === {{ $i+1 }} ? open = null : open = {{ $i+1 }}"
                                class="flex w-full items-center justify-between gap-4 bg-white px-5 py-4 text-right transition hover:bg-slate-50">
                            <span class="font-black text-ink-900">{{ $faq['q'] }}</span>
                            <svg class="h-5 w-5 shrink-0 text-brand-600 transition-transform" :class="open === {{ $i+1 }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="open === {{ $i+1 }}" x-collapse>
                            <p class="border-t border-slate-100 px-5 py-4 text-sm leading-7 text-slate-600">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== TESTIMONIALS ===================== --}}
    <section class="bg-brand-50 py-20">
        <div class="section">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="chip">آراء عملائنا</span>
                <h2 class="mt-4 text-3xl font-black text-ink-900 sm:text-4xl">بيثقوا في طلبة</h2>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @php
                    $reviews = [
                        ['n' => 'محمود ع.', 'r' => 'صاحب متجر إلكتروني', 'q' => 'الأسعار واضحة والتوصيل سريع. وفّرت عليّ وقت ومجهود كبير.', 'c' => 'bg-brand-600'],
                        ['n' => 'سارة م.', 'r' => 'عميلة', 'q' => 'حسبت التكلفة قبل ما أدفع وكانت معقولة جدًا. تجربة مريحة.', 'c' => 'bg-accent-600'],
                        ['n' => 'كريم ط.', 'r' => 'صاحب مطعم', 'q' => 'التتبع اللحظي وكود التسليم خلّوني مطمن على كل شحنة.', 'c' => 'bg-ink-900'],
                    ];
                @endphp
                @foreach ($reviews as $i => $rv)
                    <div class="reveal rounded-3xl border border-slate-100 bg-white p-6 shadow-sm" style="transition-delay:{{ $i*80 }}ms">
                        <div class="flex gap-1 text-amber-400">
                            @for ($s = 0; $s < 5; $s++)<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.36 4.18a1 1 0 0 0 .95.69h4.4c.97 0 1.37 1.24.59 1.81l-3.56 2.59a1 1 0 0 0-.36 1.12l1.36 4.18c.3.92-.76 1.69-1.54 1.12l-3.56-2.59a1 1 0 0 0-1.18 0l-3.56 2.59c-.78.57-1.84-.2-1.54-1.12l1.36-4.18a1 1 0 0 0-.36-1.12L1.7 9.6c-.78-.57-.38-1.81.59-1.81h4.4a1 1 0 0 0 .95-.69L9.05 2.93Z"/></svg>@endfor
                        </div>
                        <p class="mt-4 leading-7 text-slate-600">"{{ $rv['q'] }}"</p>
                        <div class="mt-5 flex items-center gap-3">
                            <span class="grid h-11 w-11 place-items-center rounded-full {{ $rv['c'] }} font-black text-white">{{ mb_substr($rv['n'], 0, 1) }}</span>
                            <div>
                                <p class="font-black text-ink-900">{{ $rv['n'] }}</p>
                                <p class="text-xs text-slate-400">{{ $rv['r'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== FINAL CTA ===================== --}}
    <section class="bg-white py-20">
        <div class="section">
            <div class="reveal relative overflow-hidden rounded-[2rem] bg-gradient-to-l from-ink-900 to-brand-800 p-10 text-center sm:p-14">
                <div class="hex absolute -right-6 -top-6 h-32 w-32 bg-white/5"></div>
                <div class="hex absolute -left-8 bottom-0 h-40 w-40 bg-brand-500/10"></div>
                <h2 class="relative text-3xl font-black text-white sm:text-4xl">جاهز تبعت شحنتك؟</h2>
                <p class="relative mx-auto mt-3 max-w-xl text-brand-100">احسب التكلفة وادفع أونلاين وابعت شحنتك في دقائق — بدون حساب ولا اشتراك.</p>
                <a href="{{ route('order.create') }}" class="btn-brand relative mt-7 px-8 py-3.5 text-base">اطلب توصيل الآن</a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const calc = document.getElementById('calc');
                if (!calc) return;
                const perKm = parseFloat(calc.dataset.costPerKm) || 0;
                const base = parseFloat(calc.dataset.baseFee) || 0;
                const baseDistance = parseFloat(calc.dataset.baseDistance) || 0;
                const min = parseFloat(calc.dataset.minCost) || 0;
                const range = document.getElementById('calc-km');
                const kmLabel = document.getElementById('calc-km-label');
                const totalEl = document.getElementById('calc-total');
                const fmt = (n) => Number(n).toLocaleString('ar-EG', { maximumFractionDigits: 0 });
                const update = () => {
                    const km = Number(range.value);
                    let total = base + Math.max(0, km - baseDistance) * perKm;
                    if (total < min) total = min;
                    kmLabel.textContent = fmt(km);
                    totalEl.textContent = fmt(total);
                };
                range.addEventListener('input', update);
                update();
            });
        </script>
    @endpush
</x-public-layout>
