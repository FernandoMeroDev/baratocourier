<?php

namespace App\Livewire\Forms\Users\Franchisee;

use App\Livewire\Forms\Users\UpdateForm as BasesUpdateForm;
use App\Models\User\Franchisee;
use Livewire\Attributes\Locked;

class UpdateForm extends BasesUpdateForm
{
    use Attributes;

    #[Locked]
    public Franchisee $franchisee;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules['phone_number'] = 'required|string|size:10';
        $rules['courier_name'] = 'required|string|max:255';
        $rules['logo'] = 'nullable|image|max:10240|dimensions:ratio=1/1'; // 10MB max;
        // Address
        $rules['address_line'] = 'required|string|max:255';
        $rules['state'] = 'required|string';
        $rules['city'] = 'required|string|max:50';
        $rules['zip_code'] = 'required|string|max:20';
        // End Address
        $rules['guide_domain'] = 'required|string|max:20';
        $rules['client_domain'] = 'required|string|max:20';
        $rules['waybill_text_reference'] = 'required|string|max:50';
        return $rules;
    }

    public function setFranchisee(Franchisee $franchisee)
    {
        $this->franchisee = $franchisee;
        $this->phone_number = $franchisee->phone_number;
        $this->courier_name = $franchisee->courier_name;
        $address = json_decode($franchisee->address);
        $this->address_line = $address->line_1;
        $this->state = $address->province_name;
        $this->city = $address->city_name;
        $this->zip_code = $address->zip_code;
        $this->guide_domain = $franchisee->guide_domain;
        $this->client_domain = $franchisee->client_domain;
        $this->waybill_text_reference = $franchisee->waybill_text_reference;
    }

    public function update()
    {
        $validated = parent::update();
        $validated['address'] = Franchisee::makeJSONAddress(
            $validated['address_line'],
            $validated['city'],
            $validated['state'],
            $validated['zip_code']
        );
        $validated['logo'] = $this->saveLogo();
        $this->franchisee->update($validated);
    }

    private function saveLogo(): ?string
    {
        if($this->logo){
            return substr(
                $this->logo->store(path: 'users/franchisee/logos'),
                offset: mb_strlen('users/franchisee/logos/')
            );
        }
        return $this->franchisee->logo;
    }
}
