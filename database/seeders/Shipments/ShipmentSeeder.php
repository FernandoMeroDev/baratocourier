<?php

namespace Database\Seeders\Shipments;

use App\Models\Packages\Waybills\Waybill;
use App\Models\Shipments\Shipment;
use App\Models\Shipments\ShippingBag;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipment = Shipment::factory(20)->create()->get(0);
        $bag = ShippingBag::create([
            'number' => 1,
            'shipment_id' => $shipment->id
        ]);
        $waybill = Waybill::find(1);
        $waybill->update([
            'shipping_bag_id' => $bag->id
        ]);
        $waybill->package->update([
            'status' => 'EN TRANSITO',
        ]);
    }
}
