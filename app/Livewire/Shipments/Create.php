<?php

namespace App\Livewire\Shipments;

use App\Livewire\Forms\Shipments\StoreForm;
use App\Models\Shipments\ShipmentType;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.shipments.create', [
            'types' => ShipmentType::all()
        ]);
    }

    public function store()
    {
        $this->form->store();
    }
}
