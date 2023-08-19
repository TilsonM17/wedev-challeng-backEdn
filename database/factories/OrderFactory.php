<?php

namespace Database\Factories;

use App\Enums\OrderEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement([
                OrderEnums::PENDING->value,
                OrderEnums::PROCESSING->value,
                OrderEnums::COMPLETED->value,
                OrderEnums::DECLINED->value,
            ]),
        ];
    }
}
