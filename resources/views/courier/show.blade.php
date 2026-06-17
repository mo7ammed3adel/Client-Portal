<x-courier-layout :title="$order->order_number">
    <a href="{{ route('courier.dashboard') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-bold text-slate-500">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        رجوع
    </a>

    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-lg font-black text-ink-900" dir="ltr">{{ $order->order_number }}</span>
            <x-status-badge :status="$order->status" />
        </div>

        {{-- Route --}}
        <div class="mt-4 space-y-3">
            <div class="rounded-xl bg-brand-50 p-3">
                <p class="text-[11px] font-bold text-brand-700">الاستلام من</p>
                <p class="mt-1 text-sm text-slate-700">{{ $order->pickup_address }}</p>
                <div class="mt-2 flex items-center gap-3 text-xs">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $order->pickup_lat }},{{ $order->pickup_lng }}" target="_blank" class="font-bold text-brand-600">الاتجاهات ↗</a>
                    <a href="tel:{{ $order->sender_phone }}" class="font-bold text-brand-600">اتصل بالمرسِل · {{ $order->sender_name }}</a>
                </div>
            </div>
            <div class="rounded-xl bg-slate-100 p-3">
                <p class="text-[11px] font-bold text-ink-900">التسليم إلى</p>
                <p class="mt-1 text-sm text-slate-700">{{ $order->dropoff_address }}</p>
                <div class="mt-2 flex items-center gap-3 text-xs">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $order->dropoff_lat }},{{ $order->dropoff_lng }}" target="_blank" class="font-bold text-brand-600">الاتجاهات ↗</a>
                    <a href="tel:{{ $order->receiver_phone }}" class="font-bold text-brand-600">اتصل بالمستلِم · {{ $order->receiver_name }}</a>
                </div>
            </div>
        </div>

        @if ($order->notes)
            <div class="mt-3 rounded-xl border border-slate-100 p-3">
                <p class="text-[11px] font-bold text-slate-400">ملاحظات الشحنة</p>
                <p class="mt-1 text-sm text-slate-700">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="mt-3 flex items-center justify-between rounded-xl bg-ink-900 p-3 text-white">
            <span class="text-xs text-slate-300">{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</span>
            <span class="font-black">{{ number_format($order->total_cost, 2) }} ج</span>
        </div>
    </div>

    {{-- Action: pickup OTP --}}
    @if ($order->awaitingPickup())
        <div class="mt-5 rounded-2xl border-2 border-brand-200 bg-white p-4 shadow-sm">
            <h3 class="text-base font-black text-ink-900">تأكيد الاستلام</h3>
            <p class="mt-1 text-sm text-slate-500">اطلب من المرسِل <span class="font-bold">كود الاستلام</span> المكوّن من 4 أرقام وأدخله لتأكيد استلام الشحنة.</p>
            <form method="POST" action="{{ route('courier.orders.pickup', $order) }}" class="mt-4">
                @csrf
                <input name="otp" inputmode="numeric" autocomplete="one-time-code" maxlength="8" required
                       class="w-full rounded-xl border-slate-300 text-center text-2xl font-black tracking-[0.5em] focus:border-brand-500 focus:ring-brand-500"
                       placeholder="••••" dir="ltr">
                @error('otp') <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p> @enderror
                <button class="btn-brand mt-4 w-full justify-center py-3.5 text-base">تأكيد الاستلام</button>
            </form>
        </div>
    @elseif ($order->awaitingDelivery())
        <div class="mt-5 rounded-2xl border-2 border-indigo-200 bg-white p-4 shadow-sm">
            <h3 class="text-base font-black text-ink-900">تأكيد التسليم</h3>
            <p class="mt-1 text-sm text-slate-500">اطلب من المستلِم <span class="font-bold">كود التسليم</span> المكوّن من 4 أرقام وأدخله لتأكيد تسليم الشحنة.</p>
            <form method="POST" action="{{ route('courier.orders.deliver', $order) }}" class="mt-4">
                @csrf
                <input name="otp" inputmode="numeric" autocomplete="one-time-code" maxlength="8" required
                       class="w-full rounded-xl border-slate-300 text-center text-2xl font-black tracking-[0.5em] focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="••••" dir="ltr">
                @error('otp') <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p> @enderror
                <button class="mt-4 w-full justify-center rounded-xl bg-indigo-600 py-3.5 text-base font-bold text-white transition hover:bg-indigo-500">تأكيد التسليم</button>
            </form>
        </div>
    @else
        <div class="mt-5 rounded-2xl bg-emerald-50 p-4 text-center text-emerald-700">
            <p class="font-black">تم تسليم هذه الشحنة</p>
            @if ($order->delivered_at)<p class="mt-1 text-sm">{{ $order->delivered_at->format('Y/m/d H:i') }}</p>@endif
        </div>
    @endif
</x-courier-layout>
