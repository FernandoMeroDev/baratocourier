<?php

namespace Database\Seeders\Shipments;

use App\Models\Shipments\Shipment;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipment::factory(20)->create()->get(0);
    }
}
