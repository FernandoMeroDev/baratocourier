<?php

namespace Database\Factories\Shipments;

use App\Models\User\Franchisee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipments\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->randomNumber(),
            'shipment_datetime' => fake()->dateTime(),
            'upshipment_datetime' => fake()->dateTime(),
            'status' => 'Embarcado',
            'arrival_min_date' => fake()->date(),
            'arrival_max_date' => fake()->date(),
            'shipment_type_id' => 1,
            'user_id' => Franchisee::find(1)->user->id,
        ];
    }
}
