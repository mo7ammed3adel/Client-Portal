<x-public-layout title="تم تأكيد الطلب">
    <section class="bg-slate-50 py-12 lg:py-16">
        <div class="section max-w-3xl">
            {{-- Confirmation header --}}
            <div class="reveal is-visible overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-900/5">
                <div class="relative bg-gradient-to-l from-brand-700 to-brand-500 p-8 text-center text-white">
                    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(#fff 1.5px,transparent 1.5px);background-size:22px 22px;"></div>
                    <div class="relative mx-auto grid h-16 w-16 place-items-center rounded-full bg-white/20 backdrop-blur">
                        <svg class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    </div>
                    <h1 class="relative mt-4 text-3xl font-black">تم تأكيد طلبك بنجاح!</h1>
                    <p class="relative mt-2 text-brand-50">تم استلام الدفع وبدأنا تجهيز شحنتك.</p>
                </div>

                <div class="p-8">
                    <div class="rounded-2xl border-2 border-dashed border-brand-200 bg-brand-50/50 p-5 text-center">
                        <p class="text-sm font-semibold text-slate-500">رقم تتبع الشحنة</p>
                        <p class="mt-1 text-3xl font-black tracking-wider text-brand-700" dir="ltr">{{ $order->order_number }}</p>
                        <p class="mt-2 text-xs text-slate-400">احتفظ بهذا الرقم لتتبع شحنتك في أي وقت.</p>
                    </div>

                    {{-- Pickup & delivery verification codes --}}
                    @if ($order->pickup_otp || $order->delivery_otp)
                        <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-5">
                            <div class="flex items-start gap-2">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                <p class="text-sm font-bold text-amber-800">أكواد التحقق — احتفظ بها جيدًا</p>
                            </div>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-xl bg-white p-4 text-center">
                                    <p class="text-xs text-slate-400">كود الاستلام</p>
                                    <p class="mt-1 text-2xl font-black tracking-[0.4em] text-ink-900" dir="ltr">{{ $order->pickup_otp }}</p>
                                    <p class="mt-1 text-[11px] leading-4 text-slate-400">سلّمه للمندوب عند استلام الشحنة من المرسِل.</p>
                                </div>
                                <div class="rounded-xl bg-white p-4 text-center">
                                    <p class="text-xs text-slate-400">كود التسليم</p>
                                    <p class="mt-1 text-2xl font-black tracking-[0.4em] text-ink-900" dir="ltr">{{ $order->delivery_otp }}</p>
                                    <p class="mt-1 text-[11px] leading-4 text-slate-400">أعطِه للمستلِم ليؤكد به استلام الشحنة من المندوب.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Order summary --}}
                    <div class="mt-7 space-y-5">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-bold text-brand-600">الاستلام من</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">{{ $order->pickup_address }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-bold text-ink-900">التسليم إلى</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">{{ $order->dropoff_address }}</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-slate-100 p-4">
                                <p class="text-xs font-bold text-slate-400">المرسِل</p>
                                <p class="mt-1 font-bold text-ink-900">{{ $order->sender_name }}</p>
                                <p class="text-sm text-slate-500" dir="ltr">{{ $order->sender_phone }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-100 p-4">
                                <p class="text-xs font-bold text-slate-400">المستلِم</p>
                                <p class="mt-1 font-bold text-ink-900">{{ $order->receiver_name }}</p>
                                <p class="text-sm text-slate-500" dir="ltr">{{ $order->receiver_phone }}</p>
                            </div>
                        </div>

                        @if ($order->notes)
                            <div class="rounded-2xl border border-slate-100 p-4">
                                <p class="text-xs font-bold text-slate-400">تفاصيل الشحنة</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">{{ $order->notes }}</p>
                            </div>
                        @endif

                        <div class="space-y-2.5 rounded-2xl bg-ink-900 p-5 text-sm text-slate-300">
                            <div class="flex items-center justify-between"><span>المسافة</span><span class="font-bold text-white">{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</span></div>
                            <div class="flex items-center justify-between"><span>التكلفة لكل كم</span><span class="font-bold text-white">{{ rtrim(rtrim(number_format($order->cost_per_km, 2), '0'), '.') }} جنيه</span></div>
                            <div class="my-1 border-t border-white/10"></div>
                            <div class="flex items-center justify-between text-base"><span class="font-bold text-brand-300">المدفوع</span><span class="text-2xl font-black text-white">{{ number_format($order->total_cost, 2) }} جنيه</span></div>
                        </div>
                    </div>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('order.track', ['number' => $order->order_number]) }}" class="btn-brand flex-1 justify-center py-3.5">تتبع الشحنة</a>
                        <a href="{{ route('home') }}" class="btn-outline flex-1 justify-center py-3.5">العودة للرئيسية</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
