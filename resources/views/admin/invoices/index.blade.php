<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="portal-title">إدارة الفواتير</h1>
                <p class="portal-muted mt-1">إنشاء الفواتير ومتابعة حالة الدفع.</p>
            </div>
            <a href="{{ route('admin.invoices.create') }}" class="portal-button">إنشاء فاتورة</a>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="portal-card overflow-hidden">
            @if ($invoices->isEmpty())
                <div class="p-8 text-center text-sm text-slate-500">لا توجد فواتير حتى الآن.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>الفاتورة</th>
                                <th>العميل</th>
                                <th>المبلغ</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>الحالة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="font-bold">{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->client->name }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }} ج.م</td>
                                    <td>{{ $invoice->due_date->format('Y/m/d') }}</td>
                                    <td><x-status-badge :status="$invoice->status" /></td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.invoices.update', $invoice) }}" class="flex justify-end gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="portal-input mt-0 w-36">
                                                <option value="pending" @selected($invoice->status === 'pending')>قيد الانتظار</option>
                                                <option value="paid" @selected($invoice->status === 'paid')>مدفوع</option>
                                                <option value="overdue" @selected($invoice->status === 'overdue')>متأخر</option>
                                            </select>
                                            <button class="portal-button-secondary px-3 py-2">حفظ</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $invoices->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
