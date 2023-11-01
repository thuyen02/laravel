<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\suppiler>
 */
class suppilerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'suppiler_code'=>fake()->currencyCode(),
            'suppiler_name'=>fake()->name(),
            'phone_number'=>fake()->phoneNumber(),
            'email'=>fake()->email(),
            'status'=>rand(0,1)
        ];
    }
}
