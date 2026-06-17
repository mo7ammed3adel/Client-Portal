<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $paidOrders = Order::query()->where('status', '!=', 'pending_payment');

        $stats = [
            'orders_total' => (clone $paidOrders)->count(),
            'orders_active' => (clone $paidOrders)
                ->whereIn('status', ['confirmed', 'processing', 'out_for_delivery'])
                ->count(),
            'orders_delivered' => (clone $paidOrders)->where('status', 'delivered')->count(),
            'revenue' => (float) (clone $paidOrders)->sum('total_cost'),
            'contacts_new' => ContactRequest::query()->where('status', 'new')->count(),
        ];

        $recentOrders = Order::query()
            ->where('status', '!=', 'pending_payment')
            ->latest()
            ->limit(8)
            ->get();

        $recentContacts = ContactRequest::query()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentContacts'));
    }
}
