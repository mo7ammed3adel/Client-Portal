<x-public-layout title="تتبع شحنة">
    <section class="bg-ink-900 py-16 text-white">
        <div class="section max-w-3xl text-center">
            <span class="chip mx-auto border-white/15 bg-white/10 text-brand-200">تتبع الشحنة</span>
            <h1 class="mt-5 text-3xl font-black sm:text-4xl">أين شحنتي؟</h1>
            <p class="mt-3 text-slate-300">أدخل رقم التتبع لمعرفة حالة شحنتك لحظة بلحظة.</p>

            <form action="{{ route('order.track') }}" method="GET" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                <input type="text" name="number" value="{{ $number }}" placeholder="مثال: TLB-260617-00001"
                       class="w-full rounded-xl border-0 px-4 py-3.5 text-ink-900 shadow-sm focus:ring-2 focus:ring-brand-400" dir="ltr">
                <button class="btn-brand justify-center px-7 py-3.5">تتبع</button>
            </form>
        </div>
    </section>

    <section class="bg-slate-50 py-14">
        <div class="section max-w-3xl">
            @if ($searched && ! $order)
                <div class="rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-slate-100 text-slate-400">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/></svg>
                    </div>
                    <h2 class="mt-4 text-xl font-black text-ink-900">لم نعثر على الشحنة</h2>
                    <p class="mt-2 text-slate-500">تأكد من رقم التتبع <span class="font-bold" dir="ltr">{{ $number }}</span> وحاول مرة أخرى.</p>
                </div>
            @elseif ($order)
                @php
                    $flow = ['confirmed', 'processing', 'out_for_delivery', 'delivered'];
                    $cancelled = $order->status === 'cancelled';
                    $activeIndex = $cancelled ? -1 : array_search($order->status, $flow, true);
                    $stepInfo = [
                        'confirmed' => ['t' => 'تم تأكيد الطلب', 'd' => 'تم استلام الدفع وتأكيد طلبك.'],
                        'processing' => ['t' => 'قيد التجهيز', 'd' => 'جاري تجهيز شحنتك للاستلام.'],
                        'out_for_delivery' => ['t' => 'في الطريق إليك', 'd' => 'الكابتن في الطريق لتسليم الشحنة.'],
                        'delivered' => ['t' => 'تم التسليم', 'd' => 'تم تسليم الشحنة بنجاح.'],
                    ];
                @endphp

                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <p class="text-sm text-slate-400">رقم التتبع</p>
                            <p class="text-xl font-black tracking-wide text-ink-900" dir="ltr">{{ $order->order_number }}</p>
                        </div>
                        <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-bold {{ $cancelled ? 'bg-red-50 text-red-600' : 'bg-brand-50 text-brand-700' }}">
                            <span class="h-2 w-2 rounded-full {{ $cancelled ? 'bg-red-500' : 'bg-brand-500' }}"></span>
                            {{ $order->statusLabel() }}
                        </span>
                    </div>

                    {{-- Route --}}
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs font-bold text-brand-600">من</p>
                            <p class="mt-1 text-sm leading-6 text-slate-700">{{ $order->pickup_address }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs font-bold text-ink-900">إلى</p>
                            <p class="mt-1 text-sm leading-6 text-slate-700">{{ $order->dropoff_address }}</p>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    @if ($cancelled)
                        <div class="mt-6 rounded-2xl border border-red-100 bg-red-50 p-5 text-center text-red-700">
                            <p class="font-black">تم إلغاء هذا الطلب</p>
                            <p class="mt-1 text-sm">للاستفسار يرجى التواصل مع الدعم.</p>
                        </div>
                    @else
                        <div class="mt-8">
                            <ol class="relative space-y-7 border-r-2 border-slate-100 pe-0 ps-6">
                                @foreach ($flow as $i => $key)
                                    @php $done = $i <= $activeIndex; $current = $i === $activeIndex; @endphp
                                    <li class="relative">
                                        <span class="absolute -right-[31px] grid h-6 w-6 place-items-center rounded-full ring-4 ring-white {{ $done ? 'bg-brand-600 text-white' : 'bg-slate-200 text-slate-400' }}">
                                            @if ($done)
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                            @else
                                                <span class="h-2 w-2 rounded-full bg-current"></span>
                                            @endif
                                        </span>
                                        <p class="font-black {{ $done ? 'text-ink-900' : 'text-slate-400' }}">
                                            {{ $stepInfo[$key]['t'] }}
                                            @if ($current) <span class="ms-2 rounded-full bg-brand-100 px-2 py-0.5 text-xs text-brand-700">الحالة الحالية</span> @endif
                                        </p>
                                        <p class="mt-0.5 text-sm {{ $done ? 'text-slate-500' : 'text-slate-400' }}">{{ $stepInfo[$key]['d'] }}</p>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    <div class="mt-7 flex items-center justify-between rounded-2xl bg-ink-900 p-4 text-white">
                        <span class="text-sm text-slate-300">تاريخ الطلب: {{ $order->created_at->format('Y/m/d') }}</span>
                        <span class="text-lg font-black">{{ number_format($order->total_cost, 2) }} جنيه</span>
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-10 text-center text-slate-500">
                    <img src="{{ asset('brand/truck.svg') }}" alt="" class="mx-auto h-24 w-24 opacity-90" aria-hidden="true">
                    <p class="mt-4">أدخل رقم التتبع الخاص بشحنتك في الأعلى لعرض حالتها.</p>
                </div>
            @endif
        </div>
    </section>
</x-public-layout>
