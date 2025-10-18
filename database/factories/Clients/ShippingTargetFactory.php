<?php

namespace Database\Factories\Clients;

use Database\Factories\Traits\GenerateRandomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients\ShippingTarget>
 */
class ShippingTargetFactory extends Factory
{
    use GenerateRandomNumber;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName() . ' ' . fake()->firstName(),
            'lastname' => fake()->lastName() . ' ' . fake()->lastName(),
            'identity_card' => $this->randomNumber(10),
            'phone_number' => $this->randomNumber(10),
            // 'shipping_address_id' => null,
        ];
    }
}
