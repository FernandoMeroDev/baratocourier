<?php

namespace Database\Factories\Packages;

use App\Models\Packages\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Packages\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Package::$valid_statuses['eeuu_warehouse'],
            'tracking_number' => '1Z999AA10123456784',
            'courier_name' => 'CourierA',
            'logo' => 'example.webp',
            'shipping_address' => json_encode([
                'line_1' => 'Calle Alajuela Av. San Cristobal intersección',
                'line_2' => 'Dos cuadras frente a la gasolinera',
                'city_name' => 'Portoviejo',
                'province_name' => 'Manabí',
                'zip_code' => '132222',
            ]),
            'reference'  => 'Texto de Referencia',
            'guide_domain' => 'BTC',
            'client_domain' => 'BTA',
            'client_code' => 1,
            'client_identity_card' => '1359999999',
            'client_name' => 'NombreClienteA',
            'client_lastname' => 'ApellidoClienteA',
            'shop_id' => 1,
            'package_category_id' => 1,
            'shipping_method_id'  => 1,
            // 'user_id' => $franchisee->user->id
        ];
    }
}
