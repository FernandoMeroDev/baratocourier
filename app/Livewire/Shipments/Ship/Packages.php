<?php

namespace App\Livewire\Shipments\Ship;

use App\Models\Shipments\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Packages extends Component
{
    public Shipment $shipment;

    public Collection $packages;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $this->packages = $shipment->packages();
    }

    public function render()
    {
        return view('livewire.shipments.ship.packages');
    }

    public function refreshPackages()
    {
        $this->packages = $this->shipment->packages();
    }
}
