<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('kashier_merchant_order_id')->nullable()->unique()->after('status');
            $table->string('kashier_order_id')->nullable()->after('kashier_merchant_order_id');
            $table->string('kashier_transaction_id')->nullable()->after('kashier_order_id');
            $table->string('payment_method')->nullable()->after('kashier_transaction_id');
            $table->timestamp('paid_at')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique(['kashier_merchant_order_id']);
            $table->dropColumn([
                'kashier_merchant_order_id',
                'kashier_order_id',
                'kashier_transaction_id',
                'payment_method',
                'paid_at',
            ]);
        });
    }
};
