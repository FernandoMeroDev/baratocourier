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
        elseif($waybills->isNotEmpty()){
            // Obtenemos todos los paquetes que han sido embarcados
            $packages = $this->shipment->packages();
            foreach($packages as $package){
                foreach($package->waybills as $package_waybill){
                    // Recorremos las guias de cada paquete para verificar
                    // que han sido embarcadas.
                    // Si han sido embarcadas
                    if( ! $waybills->contains($package_waybill)){
                        $error['type'] = 'missed_waybill';
                        $error['message'] = 'La Guía ' . $package_waybill->readable_number() . ' no ha sido embarcada.';
                        break 2;
                    }
                }
            }
        }
        if( ! is_null($error)){
            $error = match($error['type']){
                'empty' => 'No ha embarcado ninguna guía',
                'missed_waybill' => $error['message']
            };
            $this->dispatch('validation-error', message: $error);
        } else {
            // Cambia el estado a embarcado
            $this->shipment->update([
                'status' => Shipment::$valid_statuses['shipment']
            ]);
            // Cambia el estado de las guias a 'en transito' 
            foreach($packages as $package)
                $package->update(['status' => Package::$valid_statuses['transit']]);
            $this->redirect(route('shipments.index'));
        }
    }
}
