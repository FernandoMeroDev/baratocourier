<?php

namespace Database\Seeders\Packages;

use App\Models\Packages\Package;
use App\Models\Packages\Waybills\PersonalData;
use App\Models\Packages\Waybills\Waybill;
use App\Models\User\Franchisee;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $franchisee = Franchisee::all()->get(0);
        // $shippingAddress = ShippingAddress::find($validated['shipping_address_id']);
        $package = Package::create([
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
            'user_id' => $franchisee->user->id
        ]);
        $waybill = Waybill::create([
            'waybill_number' => Franchisee::calcWaybillNumber($franchisee),
            'price' => 20.5,
            'weight' => 4.5,
            'items_count' => 5,
            'description' => 'Texto descriptivo detallando el contenido.',
            'status' => 'Bodega USA',
            'package_id' => $package->id,
        ]);
        $personal_data = [];
        $personal_data['name'] = 'Nombre1 Nombre2';
        $personal_data['lastname'] = 'Apellido1 Apellido2';
        $personal_data['phone_number'] = '0999999999';
        $personal_data['identity_card'] = '1350000000';
        $personal_data['person_type'] = 'client';
        $personal_data['waybill_id'] = $waybill->id;
        PersonalData::create($personal_data);
    }
}
