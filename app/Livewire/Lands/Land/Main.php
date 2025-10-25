<?php

namespace App\Livewire\Lands\Land;

use App\Models\Lands\Land;
use App\Models\Packages\Waybills\Waybill;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Main extends Component
{
    public Land $land;

    public Collection $packages;

    public Collection $waybills;

    #[Validate('required|string', attribute: 'Número de Guía')]
    public $waybill_id;

    public function mount(Land $land)
    {
        $this->land = $land;
        $this->packages = new Collection([]);
        $this->waybills = new Collection([]);
    }

    public function render()
    {
        return view('livewire.lands.land.main');
    }

    public function makeLand()
    {
        $error = null;
        if($this->waybills->isEmpty())
            $error = 'No ha desembarcado ninguna guía';

        if(is_null($error)){
            $this->land->update([
                'status' => Land::$valid_statuses['landed'],
            ]);
            // Cambia el estado de las guias a 'Bodega Ecuador' 
            foreach($this->waybills as $waybill)
                $waybill->update([
                    'status' => Waybill::$valid_statuses['ecuador_warehouse'],
                    'land_id' => $this->land->id
                ]);
            $this->redirect(route('lands.index'));
        } else
            $this->dispatch('validation-error', message: $error);
    }

    public function addWaybill()
    {
        $this->validate();
        if(is_null($waybill = Waybill::findReadableNumber($this->waybill_id))) return;
        if($this->waybills->contains($waybill)) return;
        if(is_null($waybill->shipping_bag_id)) return;
        if( ! is_null($waybill->land_id)) return;
        $this->waybills->push($waybill);
        if( ! $this->packages->contains($waybill->package))
            $this->packages->push($waybill->package);
    }

    public function removeWaybill($id)
    {
        if($waybill = Waybill::find($id)){
            if( ! $this->waybills->contains($waybill)) return;
            $this->waybills = $this->waybills->except($waybill->id);
        }
    }
}
