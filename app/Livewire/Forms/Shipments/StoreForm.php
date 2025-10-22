<?php

namespace App\Livewire\Forms\Shipments;

use App\Models\Shipments\Shipment;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    public $shipping_date;

    public $reference;

    public $shipment_type_id;

    public $arrival_min_date;

    public $arrival_max_date;

    protected function rules()
    {
        return [
            'shipping_date' => 'required|date',
            'reference' => 'nullable|string',
            'shipment_type_id' => 'required|exists:shipment_types,id',
            'arrival_min_date' => 'required|date',
            'arrival_max_date' => 'required|date',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        Shipment::create([
            'number' => 1, // Como generar secuencial de los embarques?
            'shipping_date' => $validated['shipping_date'],
            'reference' => $validated['reference'],
            'status' => Shipment::$valid_statuses['unshipment'],
            'arrival_min_date' => $validated['arrival_min_date'],
            'arrival_max_date' => $validated['arrival_max_date'],
            'shipment_type_id' => $validated['shipment_type_id'],
            'user_id' => Auth::user()->id,
        ]);
        $this->reset();
    }
}
