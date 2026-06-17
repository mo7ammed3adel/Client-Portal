<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="portal-title">طلب <span dir="ltr">{{ $order->order_number }}</span></h1>
                <p class="portal-muted mt-1">تم الإنشاء في {{ $order->created_at->format('Y/m/d - H:i') }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="portal-button-secondary">رجوع للطلبات</a>
        </div>
    </x-slot>

    <div class="portal-container max-w-5xl space-y-6">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                {{-- Route --}}
                <div class="portal-card">
                    <div class="portal-card-body space-y-4">
                        <h2 class="font-bold text-slate-950 dark:text-white">مسار الشحنة</h2>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/40">
                                <p class="text-xs font-bold text-brand-600">الاستلام من</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700 dark:text-slate-200">{{ $order->pickup_address }}</p>
                                <a href="https://www.openstreetmap.org/?mlat={{ $order->pickup_lat }}&mlon={{ $order->pickup_lng }}#map=16/{{ $order->pickup_lat }}/{{ $order->pickup_lng }}" target="_blank" class="mt-2 inline-flex text-xs font-semibold text-brand-600">فتح على الخريطة ↗</a>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-800/40">
                                <p class="text-xs font-bold text-slate-900 dark:text-white">التسليم إلى</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700 dark:text-slate-200">{{ $order->dropoff_address }}</p>
                                <a href="https://www.openstreetmap.org/?mlat={{ $order->dropoff_lat }}&mlon={{ $order->dropoff_lng }}#map=16/{{ $order->dropoff_lat }}/{{ $order->dropoff_lng }}" target="_blank" class="mt-2 inline-flex text-xs font-semibold text-brand-600">فتح على الخريطة ↗</a>
                            </div>
                        </div>
                        @if ($order->notes)
                            <div>
                                <p class="text-xs font-bold text-slate-400">تفاصيل الشحنة</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700 dark:text-slate-200">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Parties --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="portal-card">
                        <div class="portal-card-body">
                            <p class="text-xs font-bold text-slate-400">المرسِل</p>
                            <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $order->sender_name }}</p>
                            <p class="text-sm text-slate-500" dir="ltr">{{ $order->sender_phone }}</p>
                        </div>
                    </div>
                    <div class="portal-card">
                        <div class="portal-card-body">
                            <p class="text-xs font-bold text-slate-400">المستلِم</p>
                            <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $order->receiver_name }}</p>
                            <p class="text-sm text-slate-500" dir="ltr">{{ $order->receiver_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Side: status + payment --}}
            <div class="space-y-6">
                <div class="portal-card">
                    <div class="portal-card-body space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="font-bold text-slate-950 dark:text-white">الحالة</h2>
                            <x-status-badge :status="$order->status" />
                        </div>
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="portal-input">
                                @foreach (\App\Models\Order::FULFILMENT_STATUSES as $key => $label)
                                    <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button class="portal-button w-full">تحديث الحالة</button>
                        </form>
                    </div>
                </div>

                {{-- Courier assignment --}}
                <div class="portal-card">
                    <div class="portal-card-body space-y-3">
                        <h2 class="font-bold text-slate-950 dark:text-white">المندوب</h2>
                        <form method="POST" action="{{ route('admin.orders.assign', $order) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <select name="courier_id" class="portal-input">
                                <option value="">— غير معيّن —</option>
                                @foreach ($couriers as $courier)
                                    <option value="{{ $courier->id }}" @selected($order->courier_id === $courier->id)>{{ $courier->name }}</option>
                                @endforeach
                            </select>
                            <button class="portal-button-secondary w-full">تعيين المندوب</button>
                        </form>
                        @if ($couriers->isEmpty())
                            <p class="text-xs text-slate-500">لا يوجد مناديب بعد. <a href="{{ route('admin.couriers.index') }}" class="font-semibold text-brand-600">أضف مندوبًا</a>.</p>
                        @endif
                    </div>
                </div>

                {{-- Verification codes + milestones --}}
                @if ($order->pickup_otp || $order->picked_up_at)
                    <div class="portal-card">
                        <div class="portal-card-body space-y-2.5 text-sm">
                            <h2 class="font-bold text-slate-950 dark:text-white">أكواد التحقق والمراحل</h2>
                            <div class="flex justify-between"><span class="text-slate-500">كود الاستلام</span><span class="font-mono font-bold" dir="ltr">{{ $order->pickup_otp }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">كود التسليم</span><span class="font-mono font-bold" dir="ltr">{{ $order->delivery_otp }}</span></div>
                            <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                            <div class="flex justify-between"><span class="text-slate-500">تم الاستلام</span><span class="font-semibold">{{ $order->picked_up_at?->format('Y/m/d H:i') ?? '—' }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">تم التسليم</span><span class="font-semibold">{{ $order->delivered_at?->format('Y/m/d H:i') ?? '—' }}</span></div>
                        </div>
                    </div>
                @endif

                <div class="portal-card">
                    <div class="portal-card-body space-y-2.5 text-sm">
                        <h2 class="font-bold text-slate-950 dark:text-white">التسعير والدفع</h2>
                        <div class="flex justify-between"><span class="text-slate-500">المسافة</span><span class="font-semibold">{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">سعر الكيلومتر</span><span class="font-semibold">{{ number_format($order->cost_per_km, 2) }} ج</span></div>
                        @if ($order->base_fee > 0)
                            <div class="flex justify-between"><span class="text-slate-500">رسوم أساسية</span><span class="font-semibold">{{ number_format($order->base_fee, 2) }} ج</span></div>
                        @endif
                        <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                        <div class="flex justify-between text-base"><span class="font-bold text-slate-900 dark:text-white">الإجمالي المدفوع</span><span class="font-black text-brand-600">{{ number_format($order->total_cost, 2) }} ج</span></div>
                        <div class="flex justify-between pt-1"><span class="text-slate-500">طريقة الدفع</span><span class="font-semibold">{{ $order->payment_method === 'wallet' ? 'محفظة' : 'بطاقة' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">تاريخ الدفع</span><span class="font-semibold">{{ $order->paid_at?->format('Y/m/d H:i') }}</span></div>
                        @if ($order->kashier_transaction_id)
                            <div class="flex justify-between"><span class="text-slate-500">رقم العملية</span><span class="font-mono text-xs" dir="ltr">{{ $order->kashier_transaction_id }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
