<?php

namespace Database\Factories\Packages\Waybills;

use App\Models\Packages\Waybills\Waybill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Packages\Waybills\Waybill>
 */
class WaybillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'waybill_number' => Franchisee::calcWaybillNumber($franchisee),
            'status' => Waybill::$valid_statuses['eeuu_warehouse'],
            'price' => fake()->randomNumber(3),
            'weight' => fake()->randomNumber(2),
            'items_count' => fake()->randomNumber(1),
            'description' => 'Texto descriptivo detallando el contenido.',
            // 'package_id' => $package->id,
        ];
    }
}
