<?php

namespace App\Livewire\Forms\Users\Franchisee;

use App\Livewire\Forms\Users\StoreForm as BaseStoreForm;
use App\Models\User\Franchisee;

class StoreForm extends BaseStoreForm
{
    public $phone_number = '';

    public $courier_name = '';

    public $logo;

    // Address
    public $address_line = '';

    public $state = '';

    public $city = '';

    public $zip_code = '';
    
    public $guide_domain = '';

    public $client_domain = '';

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
        return $rules;
    }

    public function store()
    {
        $stored = parent::store();
        extract($stored);
        $user->assignRole('franchisee');
        $validated['user_id'] = $user->id;
        $validated['address'] = $validated['address_line']
            . ', ' . $validated['state']
            . ', ' . $validated['city']
            . ', Código: ' . $validated['zip_code'];
        $validated['logo'] = $this->saveLogo();
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
