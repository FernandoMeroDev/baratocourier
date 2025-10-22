<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Province;
use App\Models\Shipments\ShipmentType;
use App\Models\Shop;
use Database\Seeders\Data\ECProvinces;
use Database\Seeders\Packages\CategorySeeder;
use Database\Seeders\Packages\PackageSeeder;
use Database\Seeders\Packages\ShippingMethodSeeder;
use Database\Seeders\Shipments\ShipmentSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach(ECProvinces::$data as $province_name)
            Province::create(['name' => $province_name]);

        $this->call([
            UserSeeder::class,
            ClientSeeder::class
        ]);

        Shop::factory(5)->create();

        $this->call([
            CategorySeeder::class,
            ShippingMethodSeeder::class,
            PackageSeeder::class,
        ]);

        ShipmentType::create(['name' => 'Aéreo']);
        ShipmentType::create(['name' => 'Marítimo']);

        $this->call([
            ShipmentSeeder::class
        ]);
    }
}
