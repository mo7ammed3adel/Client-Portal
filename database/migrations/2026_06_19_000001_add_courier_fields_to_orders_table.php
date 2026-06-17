<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('courier_id')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->string('pickup_otp', 8)->nullable()->after('notes');
            $table->string('delivery_otp', 8)->nullable()->after('pickup_otp');
            $table->timestamp('picked_up_at')->nullable()->after('paid_at');
            $table->timestamp('delivered_at')->nullable()->after('picked_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('courier_id');
            $table->dropColumn(['pickup_otp', 'delivery_otp', 'picked_up_at', 'delivered_at']);
        });
    }
};
