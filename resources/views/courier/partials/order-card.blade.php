<a href="{{ route('courier.orders.show', $order) }}" class="block rounded-2xl bg-white p-4 shadow-sm transition active:scale-[0.99]">
    <div class="flex items-center justify-between">
        <span class="text-sm font-black text-ink-900" dir="ltr">{{ $order->order_number }}</span>
        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-[11px] font-bold text-brand-700">{{ $action }}</span>
    </div>
    <div class="mt-3 space-y-2 text-sm">
        <div class="flex items-start gap-2">
            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-brand-500"></span>
            <p class="line-clamp-1 text-slate-600">{{ $order->pickup_address }}</p>
        </div>
        <div class="flex items-start gap-2">
            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-ink-900"></span>
            <p class="line-clamp-1 text-slate-600">{{ $order->dropoff_address }}</p>
        </div>
    </div>
    <div class="mt-3 flex items-center justify-between border-t border-slate-100 pt-3 text-xs text-slate-400">
        <span>{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</span>
        <span class="font-bold text-ink-900">{{ number_format($order->total_cost, 2) }} ج</span>
    </div>
</a>
