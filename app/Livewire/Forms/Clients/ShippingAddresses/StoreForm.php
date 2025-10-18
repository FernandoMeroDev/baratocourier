<?php

namespace App\Livewire\Forms\Clients\ShippingAddresses;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\ShippingAddress;
use App\Models\Clients\ShippingTarget;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes, CanSetClient;

    protected function rules(): array
    {
        return [
            'line_1' => 'required|string|max:255',
            'line_2' => 'string|max:255',
            'city_name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'province_id' => 'required|integer|exists:provinces,id',
            // Shipping Target Attributes
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'identity_card' => 'required|string|max:30',
            'phone_number' => 'required|string|max:10',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $validated['client_id'] = $this->client->id;
        $address = ShippingAddress::create($validated);
        $validated['shipping_address_id'] = $address->id;
        ShippingTarget::create($validated);
    }
}
