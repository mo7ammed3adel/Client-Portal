<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable()->unique();
            $table->string('status')->default('pending_payment')->index();

            // Sender / receiver contact details
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('receiver_name');
            $table->string('receiver_phone');

            // Pickup location
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);
            $table->text('pickup_address');

            // Drop-off location
            $table->decimal('dropoff_lat', 10, 7);
            $table->decimal('dropoff_lng', 10, 7);
            $table->text('dropoff_address');

            // Pricing snapshot (captured at order time so later setting changes don't alter the order)
            $table->decimal('distance_km', 8, 2);
            $table->decimal('cost_per_km', 8, 2);
            $table->decimal('base_fee', 8, 2)->default(0);
            $table->decimal('total_cost', 10, 2);

            $table->text('notes')->nullable();

            // Payment (Kashier) details
            $table->string('kashier_merchant_order_id')->nullable()->unique();
            $table->string('kashier_order_id')->nullable();
            $table->string('kashier_transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
