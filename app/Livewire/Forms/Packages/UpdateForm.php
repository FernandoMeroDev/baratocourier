<?php

namespace App\Livewire\Forms\Packages;

use App\Models\Clients\ShippingAddress;
use App\Models\Packages\Package;
use Livewire\Attributes\Locked;
use Livewire\Form;

class UpdateForm extends Form
{
    #[Locked]
    public Package $package;

    public $tracking_number; // Nullable

    public $reference; // Nullable

    public $shop_id;

    public $shipping_method_id;

    // Address
    public $line_1;

    public $line_2;

    public $city_name;

    public $zip_code;

    public $province_name;

    // Shipping Target Attributes:
    public $name;

    public $lastname;

    public $identity_card;

    public $phone_number;

    public function rules(): array
    {
        return [
            // Address
            'address_line' => 'required|string|max:255',
            'state' => 'required|string',
            'city' => 'required|string|max:50',
            'zip_code' => 'required|string|max:20',
        ];
    }

    public function setPackage(Package $package)
    {
        $this->package = $package;
        $this->tracking_number = $package->tracking_number;
        $this->shop_id = $package->shop_id;
        $this->reference = $package->reference;
        $this->shipping_method_id = $package->shipping_method_id;
        // Shipping Address
        $address = $package->decodeShippingAddress();
        $this->line_1 = $address->line_1;
        $this->line_2 = $address->line_2;
        $this->city_name = $address->city_name;
        $this->zip_code = $address->zip_code;
        $this->province_name = $address->province_name;
        // Shipping Target Attributes
        $this->name = $address->target->name;
        $this->lastname = $address->target->lastname;
        $this->identity_card = $address->target->identity_card;
        $this->phone_number = $address->target->phone_number;
    }

    public function update()
    {
        $this->package->update([
            'tracking_number' => $this->tracking_number,
            'shop_id' => $this->shop_id,
            'reference' => $this->reference,
            'shipping_method_id' => $this->shipping_method_id,
            'shipping_address' => ShippingAddress::buildJSONAddress(
                $this->line_1,
                $this->line_2,
                $this->city_name,
                $this->province_name,
                $this->zip_code,
                // Shipping Target Attributes
                $this->name,
                $this->lastname,
                $this->identity_card,
                $this->phone_number,
            ),
        ]);
    }
}
