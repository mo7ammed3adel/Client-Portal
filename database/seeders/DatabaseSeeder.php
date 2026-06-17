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
                    'title' => 'Instagram campaign creatives',
                    'description' => 'Create three launch visuals for the new skincare offer.',
                    'status' => 'pending',
                    'notes' => 'Brand colors and examples attached in the shared drive.',
                ],
                [
                    'title' => 'Landing page copy polish',
                    'description' => 'Review the home page headline, CTA hierarchy, and proof section.',
                    'status' => 'in_progress',
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
