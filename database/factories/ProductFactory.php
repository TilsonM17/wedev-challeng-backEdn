<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'merchant_id' => \App\Models\Merchant::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'status' => 'in_stock',
        ];
    }
}