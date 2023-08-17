<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Merchant::factory(10)->create();

        \App\Models\Product::factory(10)->create();
        \App\Models\Order::factory(10)->create();

        $allOrders = \App\Models\Order::all();

        foreach ($allOrders as $order) {
            $order->products()->attach(\App\Models\Product::inRandomOrder()->first()->id, [
                'quantity' => rand(1, 10)
            ]);
        }

        //\App\Models\OrderItem::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
