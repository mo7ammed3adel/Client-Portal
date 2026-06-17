<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Services\Delivery\PricingService;
use App\Services\Kashier\KashierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Public "create a delivery order" page, accessible without an account.
     */
    public function create(): View
    {
        return view('orders.create', [
            'costPerKm' => Setting::getFloat('cost_per_km'),
            'baseFee' => Setting::getFloat('base_fee'),
            'minOrderCost' => Setting::getFloat('min_order_cost'),
        ]);
    }

    /**
     * Validate the order, price it on the server, persist a pending draft and
     * hand off to the payment gateway. The order is only finalised (gets an
     * order number) once payment succeeds.
     */
    public function store(Request $request, PricingService $pricing, KashierService $kashier): RedirectResponse
    {
        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_phone' => ['required', 'string', 'max:30'],
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:30'],
            'pickup_lat' => ['required', 'numeric', 'between:-90,90'],
            'pickup_lng' => ['required', 'numeric', 'between:-180,180'],
            'pickup_address' => ['required', 'string', 'max:1000'],
            'dropoff_lat' => ['required', 'numeric', 'between:-90,90'],
            'dropoff_lng' => ['required', 'numeric', 'between:-180,180'],
            'dropoff_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['nullable', 'in:card,wallet'],
        ]);

        $quote = $pricing->quoteForCoordinates(
            (float) $validated['pickup_lat'],
            (float) $validated['pickup_lng'],
            (float) $validated['dropoff_lat'],
            (float) $validated['dropoff_lng'],
        );

        $order = Order::create([
            'status' => 'pending_payment',
            'sender_name' => $validated['sender_name'],
            'sender_phone' => $validated['sender_phone'],
            'receiver_name' => $validated['receiver_name'],
            'receiver_phone' => $validated['receiver_phone'],
            'pickup_lat' => $validated['pickup_lat'],
            'pickup_lng' => $validated['pickup_lng'],
            'pickup_address' => $validated['pickup_address'],
            'dropoff_lat' => $validated['dropoff_lat'],
            'dropoff_lng' => $validated['dropoff_lng'],
            'dropoff_address' => $validated['dropoff_address'],
            'distance_km' => $quote['distance_km'],
            'cost_per_km' => $quote['cost_per_km'],
            'base_fee' => $quote['base_fee'],
            'total_cost' => $quote['total_cost'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $payment = $kashier->createOrderPayment($order, $validated['payment_method'] ?? 'card');

        $order->forceFill([
            'kashier_merchant_order_id' => $payment['merchant_order_id'],
            'payment_method' => $payment['method'],
        ])->save();

        return redirect()->away($payment['payment_url']);
    }

    /**
     * Re-initiate payment for an order that is still awaiting payment.
     */
    public function retryPayment(Order $order, KashierService $kashier): RedirectResponse
    {
        if ($order->isPaid()) {
            return redirect()->route('order.success', $order->order_number);
        }

        $payment = $kashier->createOrderPayment($order, $order->payment_method ?: 'card');

        $order->forceFill([
            'kashier_merchant_order_id' => $payment['merchant_order_id'],
            'payment_method' => $payment['method'],
        ])->save();

        return redirect()->away($payment['payment_url']);
    }

    /**
     * Success confirmation page, shown after payment is recorded.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->whereNotNull('paid_at')
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    /**
     * Payment failed / cancelled page with the option to retry.
     */
    public function failed(Request $request): View
    {
        $order = Order::query()
            ->where('status', 'pending_payment')
            ->find($request->integer('order'));

        return view('orders.failed', compact('order'));
    }

    /**
     * Public shipment tracking (Bosta / Aramex style) by order number.
     */
    public function track(Request $request): View
    {
        $number = trim((string) $request->query('number', ''));
        $order = null;
        $searched = $number !== '';

        if ($searched) {
            $order = Order::query()
                ->where('order_number', $number)
                ->whereNotNull('paid_at')
                ->first();
        }

        return view('orders.track', compact('order', 'number', 'searched'));
    }
}
