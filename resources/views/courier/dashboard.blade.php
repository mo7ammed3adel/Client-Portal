<x-courier-layout title="الطلبات">
    {{-- Stats --}}
    <div class="mb-5 grid grid-cols-3 gap-3">
        <div class="rounded-2xl bg-white p-3 text-center shadow-sm">
            <p class="text-2xl font-black text-ink-900">{{ $availablePickups->count() }}</p>
            <p class="mt-0.5 text-[11px] text-slate-400">للاستلام</p>
        </div>
        <div class="rounded-2xl bg-white p-3 text-center shadow-sm">
            <p class="text-2xl font-black text-ink-900">{{ $myDeliveries->count() }}</p>
            <p class="mt-0.5 text-[11px] text-slate-400">للتسليم</p>
        </div>
        <div class="rounded-2xl bg-white p-3 text-center shadow-sm">
            <p class="text-2xl font-black text-brand-600">{{ $deliveredToday }}</p>
            <p class="mt-0.5 text-[11px] text-slate-400">تم اليوم</p>
        </div>
    </div>

    {{-- Deliveries in progress --}}
    @if ($myDeliveries->isNotEmpty())
        <h2 class="mb-2 flex items-center gap-2 text-sm font-black text-ink-900">
            <span class="h-2 w-2 rounded-full bg-indigo-500"></span> جاري التوصيل
        </h2>
        <div class="mb-6 space-y-3">
            @foreach ($myDeliveries as $order)
                @include('courier.partials.order-card', ['order' => $order, 'action' => 'تسليم'])
            @endforeach
        </div>
    @endif

    {{-- Available pickups --}}
    <h2 class="mb-2 flex items-center gap-2 text-sm font-black text-ink-900">
        <span class="h-2 w-2 rounded-full bg-brand-500"></span> بانتظار الاستلام
    </h2>
    @if ($availablePickups->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-400">
            لا توجد شحنات بانتظار الاستلام حاليًا.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($availablePickups as $order)
                @include('courier.partials.order-card', ['order' => $order, 'action' => 'استلام'])
            @endforeach
        </div>
    @endif
</x-courier-layout>
