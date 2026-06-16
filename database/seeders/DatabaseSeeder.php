<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Marketing Consultant',
            'email' => 'admin@clientportal.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $client = User::factory()->create([
            'name' => 'Acme Studio',
            'email' => 'client@clientportal.test',
            'password' => 'password',
            'role' => 'client',
        ]);

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
