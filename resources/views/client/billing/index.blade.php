<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">Billing</h1>
            <p class="portal-muted mt-1">Invoices and manual payment tracking.</p>
        </div>
    </x-slot>

    <div class="portal-container">
        <div class="grid gap-4 md:grid-cols-3">
            <x-metric-card label="Total Contract Amount" :value="'$'.number_format($total, 2)" />
            <x-metric-card label="Paid Amount" :value="'$'.number_format($paid, 2)" />
            <x-metric-card label="Remaining Amount" :value="'$'.number_format($remaining, 2)" />
        </div>

        <div class="portal-card mt-6 overflow-hidden">
            <div class="portal-card-body border-b border-slate-200 dark:border-slate-800">
                <h2 class="font-bold text-slate-950 dark:text-white">Invoices</h2>
            </div>
            @if ($invoices->isEmpty())
                <div class="p-8 text-center text-sm text-slate-500">No invoices yet.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="font-bold">{{ $invoice->invoice_number }}</td>
                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                    <td><x-status-badge :status="$invoice->status" /></td>
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

