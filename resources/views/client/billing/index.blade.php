<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">Billing</h1>
            <p class="portal-muted mt-1">Invoices and manual payment tracking.</p>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-800 dark:border-blue-900 dark:bg-blue-950 dark:text-blue-200">
                {{ session('status') }}
            </div>
        @endif

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
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="font-bold">{{ $invoice->invoice_number }}</td>
                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                    <td><x-status-badge :status="$invoice->status" /></td>
                                    <td>
                                        @if ($invoice->status === 'paid')
                                            <span class="text-xs font-semibold text-slate-500">Paid</span>
                                        @else
                                            <form method="POST" action="{{ route('client.billing.pay', $invoice) }}" class="flex flex-wrap items-center gap-2">
                                                @csrf
                                                <select name="method" class="h-10 rounded-lg border-slate-300 bg-white text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                                    <option value="card">Card</option>
                                                    <option value="wallet">Wallet</option>
                                                </select>
                                                <button class="portal-button px-3 py-2 text-xs" type="submit">Pay with Kashier</button>
                                            </form>
                                        @endif
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
