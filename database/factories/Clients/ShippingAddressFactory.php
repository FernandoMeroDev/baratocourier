<?php

namespace Database\Factories\Clients;

use App\Models\Province;
use Database\Factories\Traits\GenerateRandomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShippingAddressFactory extends Factory
{
    use GenerateRandomNumber;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $max_province_id = Province::all()->count();
        return [
            'line_1' => fake()->address(),
            'line_2' => fake()->sentence(),
            'city_name' => fake()->city(),
            'zip_code' => '13' . $this->randomNumber(3),
            'province_id' => fake()->numberBetween(1, $max_province_id),
            // 'client_id' => null
        ];
    }
}