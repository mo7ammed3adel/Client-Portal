<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">لوحة التحكم</h1>
            <p class="portal-muted mt-1">نظرة عامة على طلبات التوصيل ورسائل العملاء.</p>
        </div>
    </x-slot>

    <div class="portal-container space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-metric-card label="إجمالي الطلبات المدفوعة" :value="number_format($stats['orders_total'])" hint="طلبات تم دفعها" />
            <x-metric-card label="طلبات نشطة" :value="number_format($stats['orders_active'])" hint="قيد التجهيز أو التوصيل" />
            <x-metric-card label="تم تسليمها" :value="number_format($stats['orders_delivered'])" />
            <x-metric-card label="إجمالي الإيرادات" :value="number_format($stats['revenue'], 2).' ج'" hint="من الطلبات المدفوعة" />
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="portal-card">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                        <h2 class="font-bold text-slate-950 dark:text-white">أحدث الطلبات</h2>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-brand-600">عرض الكل</a>
                    </div>
                    @if ($recentOrders->isEmpty())
                        <x-empty-state title="لا توجد طلبات بعد" message="الطلبات المدفوعة ستظهر هنا." />
                    @else
                        <div class="overflow-x-auto">
                            <table class="portal-table">
                                <thead>
                                    <tr>
                                        <th>رقم التتبع</th>
                                        <th>المرسِل</th>
                                        <th>المسافة</th>
                                        <th>التكلفة</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach ($recentOrders as $order)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                            <td><a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-brand-600" dir="ltr">{{ $order->order_number }}</a></td>
                                            <td>{{ $order->sender_name }}</td>
                                            <td>{{ rtrim(rtrim(number_format($order->distance_km, 2), '0'), '.') }} كم</td>
                                            <td class="font-semibold">{{ number_format($order->total_cost, 2) }} ج</td>
                                            <td><x-status-badge :status="$order->status" /></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="portal-card">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                        <h2 class="font-bold text-slate-950 dark:text-white">رسائل جديدة</h2>
                        @if ($stats['contacts_new'] > 0)
                            <span class="rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-bold text-brand-700">{{ $stats['contacts_new'] }}</span>
                        @endif
                    </div>
                    @if ($recentContacts->isEmpty())
                        <div class="p-5 text-sm text-slate-500">لا توجد رسائل.</div>
                    @else
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($recentContacts as $contact)
                                <li>
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="block px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-slate-900 dark:text-white">{{ $contact->name }}</span>
                                            <x-status-badge :status="$contact->status" />
                                        </div>
                                        <p class="mt-1 line-clamp-1 text-sm text-slate-500">{{ $contact->message }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-800">
                        <a href="{{ route('admin.contacts.index') }}" class="text-sm font-semibold text-brand-600">كل الرسائل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
