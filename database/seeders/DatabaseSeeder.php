<?php

namespace Database\Seeders;

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
        User::query()->updateOrCreate(
            ['email' => 'admin@clientportal.test'],
            [
                'name' => 'Marketing Consultant',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $client = User::query()->updateOrCreate(
            ['email' => 'client@clientportal.test'],
            [
                'name' => 'Acme Studio',
                'phone' => '+201000000000',
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'client',
            ]
        );

        if ($client->tasks()->doesntExist()) {
            $client->tasks()->createMany([
                [
                    'title' => 'Delivery order',
                    'description' => 'Building 12, second floor, apartment 5.',
                    'status' => 'pending',
                    'delivery_latitude' => 30.0444000,
                    'delivery_longitude' => 31.2357000,
                    'address_details' => 'Building 12, second floor, apartment 5. Near Tahrir Square.',
                ],
                [
                    'title' => 'Delivery order',
                    'description' => 'Villa 7, gate 3, ring the outside bell.',
                    'status' => 'in_progress',
                    'delivery_latitude' => 30.0131000,
                    'delivery_longitude' => 31.2089000,
                    'address_details' => 'Villa 7, gate 3, ring the outside bell. Call before arrival.',
                ],
            ]);
        }

        if ($client->invoices()->doesntExist()) {
            $client->invoices()->createMany([
            [
                'invoice_number' => 'INV-1001',
                'amount' => 1200,
                'due_date' => now()->addDays(7),
                'status' => 'pending',
            ],
            [
                'invoice_number' => 'INV-1000',
                'amount' => 800,
                'due_date' => now()->subDays(10),
                'status' => 'paid',
            ],
            ]);
        }
    }
}
