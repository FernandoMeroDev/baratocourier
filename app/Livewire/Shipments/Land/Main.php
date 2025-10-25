<?php

namespace App\Livewire\Shipments\Land;

use App\Models\Packages\Package;
use App\Models\Packages\Waybills\Waybill;
use App\Models\Shipments\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Main extends Component
{
    public Shipment $shipment;

    public Collection $packages;

    public Collection $required_waybills;

    public Collection $waybills;

    #[Validate('required|string', attribute: 'Número de Guía')]
    public $waybill_id;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $this->packages = $shipment->packages;
        $this->required_waybills = new Collection([]);
        foreach($this->packages as $package)
            foreach($package->waybillsInBag() as $waybill)
                $this->required_waybills->push($waybill);
        $this->waybills = new Collection([]);
    }

    public function render()
    {
        return view('livewire.shipments.land.main');
    }

    public function land()
    {
        $error = null;
        if($this->waybills->isEmpty())
            $error = 'No ha desembarcado ninguna guía';
        else {
            // Check is all required waybills were scanned
            foreach($this->required_waybills as $required_waybill){
                if( ! $this->waybills->contains($required_waybill)){
                    $error = 'La Guía ' . $required_waybill->readable_number() . ' no ha sido escaneada.';
                    break;
                }
            }
        }
        if(is_null($error)){
            $this->shipment->update([
                'status' => Shipment::$valid_statuses['landed'],
                'unshipment_datetime' => now()
            ]);
            // Cambia el estado de las guias (paquete) a 'Bodega Ecuador' 
            foreach($this->shipment->packages as $package)
                $package->update(['status' => Package::$valid_statuses['ecuador_warehouse']]);
            $this->redirect(route('shipments.landables'));
        } else
            $this->dispatch('validation-error', message: $error);
    }

    public function addWaybill()
    {
        $this->validate();
        if(is_null($waybill = Waybill::findReadableNumber($this->waybill_id))) return;
        if(
            ! $this->required_waybills->contains($waybill)
            || $this->waybills->contains($waybill)) return;
        if(is_null($waybill->shipping_bag_id)) return;
        $this->waybills->push($waybill);
    }

    public function removeWaybill($id)
    {
        if($waybill = Waybill::find($id)){
            if( ! $this->waybills->contains($waybill)) return;
            $this->waybills = $this->waybills->except($waybill->id);
        }
    }
}
