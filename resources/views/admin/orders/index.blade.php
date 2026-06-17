<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">طلبات التوصيل</h1>
            <p class="portal-muted mt-1">راجع الطلبات المدفوعة وحدّث حالة التنفيذ.</p>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" class="mb-5 flex flex-wrap items-center gap-3">
            <input type="search" name="search" value="{{ $search }}" placeholder="بحث برقم التتبع أو الاسم أو الهاتف" class="portal-input mt-0 w-72">
            <select name="status" class="portal-input mt-0 w-52">
                <option value="">كل الحالات</option>
                @foreach (\App\Models\Order::FULFILMENT_STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="portal-button-secondary">تصفية</button>
        </form>

        @if ($orders->isEmpty())
            <x-empty-state title="لا توجد طلبات" message="الطلبات المدفوعة من الموقع ستظهر هنا." />
        @else
            <div class="portal-card overflow-x-auto">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>رقم التتبع</th>
                            <th>المرسِل → المستلِم</th>
                            <th>المسافة</th>
                            <th>التكلفة</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-brand-600" dir="ltr">{{ $order->order_number }}</a></td>
                                <td>
                                    <span class="font-semibold text-slate-900 dark:text-white">{{ $order->sender_name }}</span>
                                    <span class="text-slate-400">←</span>
                                    {{ $order->receiver_name }}
                                </td>
                                <td>{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</td>
                                <td class="font-semibold">{{ number_format($order->total_cost, 2) }} ج</td>
                                <td class="text-slate-500">{{ $order->created_at->format('Y/m/d') }}</td>
                                <td><x-status-badge :status="$order->status" /></td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-brand-600">تفاصيل</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>
</x-app-layout>
