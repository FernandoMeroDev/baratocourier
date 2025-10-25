<?php

namespace App\Livewire\Shipments\Ship;

use App\Models\Packages\Package;
use App\Models\Shipments\Shipment;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Main extends Component
{
    #[Locked]
    public Shipment $shipment;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function render()
    {
        return view('livewire.shipments.ship.main');
    }

    public function ship()
    {
        // Validar que al menos hay una saca
        $waybills = $this->shipment->waybills();
        $error = null;
        if($waybills->isEmpty())
            $error = ['type' => 'empty'];
        if( ! is_null($error)){
            $error = match($error['type']){
                'empty' => 'No ha embarcado ninguna guía',
                'missed_waybill' => $error['message']
            };
            $this->dispatch('validation-error', message: $error);
        } else {
            // Cambia el estado a embarcado
            $this->shipment->update([
                'shipment_datetime' => now(),
                'status' => Shipment::$valid_statuses['shipment']
            ]);
            // Cambia el estado de las guias (paquete) a 'en transito' 
            $packages = $this->shipment->packagesByWaybills();
            foreach($packages as $package)
                $package->update([
                    'status' => Package::$valid_statuses['transit'],
                    'shipment_id' => $this->shipment->id
                ]);
            $this->redirect(route('shipments.index'));
        }
    }
}
