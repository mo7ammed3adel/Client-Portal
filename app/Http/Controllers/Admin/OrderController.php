<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = $request->string('search')->toString();

        $orders = Order::query()
            ->where('status', '!=', 'pending_payment')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('order_number', 'like', "%{$search}%")
                        ->orWhere('sender_name', 'like', "%{$search}%")
                        ->orWhere('sender_phone', 'like', "%{$search}%")
                        ->orWhere('receiver_name', 'like', "%{$search}%")
                        ->orWhere('receiver_phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    public function show(Order $order): View
    {
        abort_if($order->status === 'pending_payment', 404);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        abort_if($order->status === 'pending_payment', 404);

        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::FULFILMENT_STATUSES))],
        ]);

        $order->update($validated);

        return back()->with('status', 'تم تحديث حالة الطلب.');
    }
}
