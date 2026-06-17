<?php

namespace Database\Seeders;

use App\Models\ContactRequest;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Administrator account (firstOrCreate so redeploys don't reset the password).
        User::query()->firstOrCreate(
            ['email' => 'melsaprot2001@gmail.com'],
            [
                'name' => 'مدير طلبة',
                'phone' => '01068851272',
                'password' => Hash::make('Talba@2026'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Demo courier account for the captain PWA.
        $courier = User::query()->firstOrCreate(
            ['email' => 'captain@talba.eg'],
            [
                'name' => 'كابتن تجريبي',
                'phone' => '01000000000',
                'password' => Hash::make('password'),
                'role' => 'courier',
                'email_verified_at' => now(),
            ]
        );

        // Editable settings (pricing + site content). Seed any missing keys
        // with their documented defaults without overwriting existing values.
        foreach (Setting::DEFAULTS as $key => $value) {
            Setting::query()->firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // Sample paid orders so the dashboards are not empty on a fresh install.
        if (Order::query()->doesntExist()) {
            $samples = [
                [
                    'order_number' => 'TLB-260617-00001',
                    'status' => 'confirmed',
                    'sender_name' => 'أحمد محمود',
                    'sender_phone' => '+201001234567',
                    'receiver_name' => 'سارة علي',
                    'receiver_phone' => '+201117654321',
                    'pickup_lat' => 30.0444000,
                    'pickup_lng' => 31.2357000,
                    'pickup_address' => 'وسط البلد، القاهرة - بالقرب من ميدان التحرير.',
                    'dropoff_lat' => 30.0131000,
                    'dropoff_lng' => 31.2089000,
                    'dropoff_address' => 'المهندسين، الجيزة - شارع جامعة الدول العربية.',
                    'distance_km' => 5.40,
                    'cost_per_km' => 10,
                    'base_fee' => 0,
                    'total_cost' => 54.00,
                    'notes' => 'مستندات هامة، يرجى التعامل بحرص.',
                    'payment_method' => 'card',
                    'paid_at' => now()->subDays(2),
                    'pickup_otp' => '1234',
                    'delivery_otp' => '5678',
                ],
                [
                    'order_number' => 'TLB-260617-00002',
                    'status' => 'out_for_delivery',
                    'courier_id' => $courier->id,
                    'sender_name' => 'منى حسن',
                    'sender_phone' => '+201228889990',
                    'receiver_name' => 'خالد إبراهيم',
                    'receiver_phone' => '+201006667778',
                    'pickup_lat' => 30.0626000,
                    'pickup_lng' => 31.2497000,
                    'pickup_address' => 'العباسية، القاهرة.',
                    'dropoff_lat' => 30.0084000,
                    'dropoff_lng' => 31.4913000,
                    'dropoff_address' => 'التجمع الخامس، القاهرة الجديدة.',
                    'distance_km' => 24.10,
                    'cost_per_km' => 10,
                    'base_fee' => 0,
                    'total_cost' => 241.00,
                    'notes' => 'كرتونة ملابس.',
                    'payment_method' => 'wallet',
                    'paid_at' => now()->subDay(),
                    'pickup_otp' => '4321',
                    'delivery_otp' => '8765',
                    'picked_up_at' => now()->subHours(3),
                ],
            ];

            foreach ($samples as $i => $sample) {
                $order = Order::create($sample);
                $order->forceFill([
                    'kashier_merchant_order_id' => 'order-'.$order->id.'-seed-'.($i + 1),
                ])->save();
            }
        }

        if (ContactRequest::query()->doesntExist()) {
            ContactRequest::create([
                'name' => 'عميل محتمل',
                'email' => 'lead@example.com',
                'phone' => '+201005556667',
                'message' => 'أريد الاستفسار عن أسعار الشحن للشركات والكميات الكبيرة.',
                'status' => 'new',
            ]);
        }
    }
}
