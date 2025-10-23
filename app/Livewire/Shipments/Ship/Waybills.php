<?php

namespace App\Livewire\Shipments\Ship;

use App\Models\Packages\Waybills\Waybill;
use App\Models\Shipments\ShippingBag;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Waybills extends Component
{
    public ?ShippingBag $bag;

    public Collection $waybills;

    #[Validate('required|string', attribute: 'Número de Guía')]
    public $waybill_id;

    public function render()
    {
        return view('livewire.shipments.ship.waybills');
    }

    #[On('changed-bag')]
    public function refreshWaybills($id)
    {
        $this->bag = ShippingBag::find($id);
        $this->waybills = $this->bag->waybills;
    }

    public function addWaybill()
    {
        $this->validate();
        $waybill = Waybill::findReadableNumber($this->waybill_id);
        if($this->waybills->contains($waybill)) return;
        if( ! is_null($waybill->shipping_bag_id)) return;
        $waybill->update([
            'shipping_bag_id' => $this->bag->id
        ]);
        $this->waybills->push($waybill);
        $this->dispatch('changed-waybills');
    }

    public function removeWaybill($id)
    {
        if($waybill = Waybill::find($id)){
            if( ! $this->waybills->contains($waybill)) return;
            $waybill->update(['shipping_bag_id' => null]);
            $this->waybills = $this->waybills->except($waybill->id);
            $this->dispatch('changed-waybills');
        }
    }
}
