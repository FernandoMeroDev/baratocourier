<?php

namespace App\Livewire\Forms\Users\Franchisee;

use App\Livewire\Forms\Users\StoreForm as BaseStoreForm;
use App\Models\User\Franchisee;

class StoreForm extends BaseStoreForm
{
    use Attributes;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules['phone_number'] = 'required|string|size:10';
        $rules['courier_name'] = 'required|string|max:255';
        $rules['logo'] = 'required|image|max:10240|dimensions:ratio=1/1'; // 10MB max;
        // Address
        $rules['address_line'] = 'required|string|max:255';
        $rules['state'] = 'required|string';
        $rules['city'] = 'required|string|max:50';
        $rules['zip_code'] = 'required|string|max:20';
        $rules['guide_domain'] = 'required|string|max:20';
        $rules['client_domain'] = 'required|string|max:20';
        $rules['waybill_text_reference'] = 'required|string|max:50';
        return $rules;
    }

    public function store()
    {
        $stored = parent::store();
        extract($stored);
        $user->assignRole('franchisee');
        $validated['user_id'] = $user->id;
        $validated['address'] = Franchisee::makeJSONAddress(
            $validated['address_line'],
            $validated['city'],
            $validated['state'],
            $validated['zip_code']
        );
        $validated['logo'] = $this->saveLogo();
        $validated['waybill_styles'] = json_encode(Franchisee::defaultWaybillStyles());
        Franchisee::create($validated);
    }

    private function saveLogo(): ?string
    {
        if($this->logo){
            return substr(
                $this->logo->store(path: 'users/franchisee/logos'),
                offset: mb_strlen('users/franchisee/logos/')
            );
        }
        return null;
    }
}
