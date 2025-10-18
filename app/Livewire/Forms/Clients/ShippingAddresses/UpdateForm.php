<?php

namespace App\Livewire\Forms\Clients\ShippingAddresses;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\ShippingAddress;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
    use Attributes, CanSetClient;

    #[Locked]
    public ShippingAddress $shipping_address;

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

    public function setShippingAddress(ShippingAddress $shipping_address)
    {
        $this->shipping_address = $shipping_address;
        $this->line_1 = $shipping_address->line_1;
        $this->line_2 = $shipping_address->line_2;
        $this->city_name = $shipping_address->city_name;
        $this->zip_code = $shipping_address->zip_code;
        $this->province_id = $shipping_address->province_id;
        // Shipping Target Attributes
        $this->name = $shipping_address->target->name;
        $this->lastname = $shipping_address->target->lastname;
        $this->identity_card = $shipping_address->target->identity_card;
        $this->phone_number = $shipping_address->target->phone_number;
    }

    public function update()
    {
        $validated = $this->validate();
        $this->shipping_address->update($validated);
        $this->shipping_address->target->update($validated);
    }
}
