<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'status',
        'courier_id',
        'sender_name',
        'sender_phone',
        'receiver_name',
        'receiver_phone',
        'pickup_lat',
        'pickup_lng',
        'pickup_address',
        'dropoff_lat',
        'dropoff_lng',
        'dropoff_address',
        'distance_km',
        'cost_per_km',
        'base_fee',
        'base_distance_km',
        'total_cost',
        'notes',
        'pickup_otp',
        'delivery_otp',
        'kashier_merchant_order_id',
        'kashier_order_id',
        'kashier_transaction_id',
        'payment_method',
        'paid_at',
        'picked_up_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'pickup_lat' => 'decimal:7',
            'pickup_lng' => 'decimal:7',
            'dropoff_lat' => 'decimal:7',
            'dropoff_lng' => 'decimal:7',
            'distance_km' => 'decimal:2',
            'cost_per_km' => 'decimal:2',
            'base_fee' => 'decimal:2',
            'base_distance_km' => 'decimal:2',
            'total_cost' => 'decimal:2',
            'paid_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    /**
     * Ordered list of fulfilment statuses (excludes the pre-payment draft state).
     *
     * @var array<string, string>
     */
    public const FULFILMENT_STATUSES = [
        'confirmed' => 'تم التأكيد',
        'processing' => 'قيد التجهيز',
        'out_for_delivery' => 'في الطريق إليك',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
    ];

    public function statusLabel(): string
    {
        if ($this->status === 'pending_payment') {
            return 'بانتظار الدفع';
        }

        return self::FULFILMENT_STATUSES[$this->status] ?? $this->status;
    }

    public function isPaid(): bool
    {
        return $this->status !== 'pending_payment' && $this->paid_at !== null;
    }

    /**
     * Whether a courier may still collect this shipment from the sender.
     */
    public function awaitingPickup(): bool
    {
        return in_array($this->status, ['confirmed', 'processing'], true);
    }

    /**
     * Whether this shipment has been collected and is on its way.
     */
    public function awaitingDelivery(): bool
    {
        return $this->status === 'out_for_delivery';
    }

    /**
     * Only orders that have been paid for are "real" customer orders.
     */
    public function scopePaid($query)
    {
        return $query->where('status', '!=', 'pending_payment');
    }
}
