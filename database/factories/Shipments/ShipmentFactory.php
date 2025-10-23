<?php

namespace Database\Factories\Shipments;

use App\Models\Shipments\Shipment;
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
            'number' => fake()->numberBetween(1, 999999),
            'shipping_date' => fake()->date(),
            'reference' => fake()->sentence(),
            // 'shipment_datetime' => fake()->dateTime(),
            // 'upshipment_datetime' => fake()->dateTime(),
            'status' => Shipment::$valid_statuses['unshipment'],
            'arrival_min_date' => fake()->date(),
            'arrival_max_date' => fake()->date(),
            'shipment_type_id' => 1,
            'user_id' => Franchisee::find(1)->user->id,
        ];
    }
}
