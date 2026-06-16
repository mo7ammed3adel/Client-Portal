<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function __invoke(Request $request): View
    {
        $invoices = $request->user()
            ->invoices()
            ->latest()
            ->paginate(10);

        $allInvoices = $request->user()->invoices()->get();
        $total = $allInvoices->sum('amount');
        $paid = $allInvoices->where('status', 'paid')->sum('amount');
        $remaining = $total - $paid;

        return view('client.billing.index', compact('invoices', 'total', 'paid', 'remaining'));
    }
}
