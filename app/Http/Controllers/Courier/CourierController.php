<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CourierController extends Controller
{
    public function dashboard(Request $request): View
    {
        $courierId = $request->user()->id;

        // Paid orders still waiting for collection, either unassigned or mine.
        $availablePickups = Order::query()
            ->whereIn('status', ['confirmed', 'processing'])
            ->where(fn ($q) => $q->whereNull('courier_id')->orWhere('courier_id', $courierId))
            ->latest()
            ->get();

        // Shipments I have collected and still need to deliver.
        $myDeliveries = Order::query()
            ->where('status', 'out_for_delivery')
            ->where('courier_id', $courierId)
            ->latest()
            ->get();

        $deliveredToday = Order::query()
            ->where('courier_id', $courierId)
            ->where('status', 'delivered')
            ->whereDate('delivered_at', now()->toDateString())
            ->count();

        return view('courier.dashboard', compact('availablePickups', 'myDeliveries', 'deliveredToday'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeAccess($request, $order);

        return view('courier.show', compact('order'));
    }

    public function confirmPickup(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeAccess($request, $order);

        abort_unless($order->awaitingPickup(), 404);

        $validated = $request->validate([
            'otp' => ['required', 'string'],
        ]);

        if (! hash_equals((string) $order->pickup_otp, trim($validated['otp']))) {
            throw ValidationException::withMessages([
                'otp' => 'كود الاستلام غير صحيح. اطلبه من المرسِل وحاول مرة أخرى.',
            ]);
        }

        $order->forceFill([
            'courier_id' => $request->user()->id,
            'status' => 'out_for_delivery',
            'picked_up_at' => now(),
        ])->save();

        return redirect()
            ->route('courier.orders.show', $order)
            ->with('status', 'تم تأكيد استلام الشحنة. في الطريق للتسليم الآن.');
    }

    public function confirmDelivery(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeAccess($request, $order);

        abort_unless($order->awaitingDelivery() && $order->courier_id === $request->user()->id, 404);

        $validated = $request->validate([
            'otp' => ['required', 'string'],
        ]);

        if (! hash_equals((string) $order->delivery_otp, trim($validated['otp']))) {
            throw ValidationException::withMessages([
                'otp' => 'كود التسليم غير صحيح. اطلبه من المستلِم وحاول مرة أخرى.',
            ]);
        }

        $order->forceFill([
            'status' => 'delivered',
            'delivered_at' => now(),
        ])->save();

        return redirect()
            ->route('courier.dashboard')
            ->with('status', 'تم تأكيد تسليم الشحنة بنجاح. شكرًا لك!');
    }

    /**
     * A courier may only see orders that are unassigned-and-collectable, or
     * already linked to them.
     */
    private function authorizeAccess(Request $request, Order $order): void
    {
        $courierId = $request->user()->id;

        $unassignedPickup = $order->awaitingPickup() && $order->courier_id === null;
        $mine = $order->courier_id === $courierId;

        abort_unless($unassignedPickup || $mine, 404);
    }
}
