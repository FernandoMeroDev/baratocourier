<?php

namespace App\Livewire\Shipments\Ship;

use App\Models\Shipments\Shipment;
use App\Models\Shipments\ShippingBag;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Bags extends Component
{
    public Shipment $shipment;

    public Collection $shipping_bags;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $this->shipping_bags = $shipment->bags;
    }

    public function render()
    {
        return view('livewire.shipments.ship.bags');
    }

    public function addBag()
    {
        $this->shipping_bags->push(ShippingBag::create([
            'shipment_id' => $this->shipment->id,
            'number' => $this->shipment->bags->count() + 1
        ]));
    }
}
