<?php

namespace App\Livewire\Forms\Users\Franchisee;

use App\Livewire\Forms\Users\StoreForm as BaseStoreForm;
use App\Models\User\Franchisee;

class StoreForm extends BaseStoreForm
{
    public $courier_name = '';

    public $logo;

    // Address
    public $state = '';

    public $city = '';

    public $zip_code = '';
    
    public $guide_domain = '';

    public $client_domain = '';

    public function rules(): array
    {
        $rules = parent::rules();
        $rules['courier_name'] = 'required|string';
        $rules['logo'] = 'nullable|image|max:10240'; // 10MB max;
        // Address
        $rules['state'] = 'required|string';
        $rules['city'] = 'required|string';
        $rules['zip_code'] = 'required|string';
        $rules['guide_domain'] = 'required|string';
        $rules['client_domain'] = 'required|string';
        return $rules;
    }

    public function store()
    {
        $stored = parent::store();
        extract($stored);
        $user->assignRole('franchisee');
        $validated['user_id'] = $user->id;
        $validated['address'] = $validated['state']
            . ', ' . $validated['city']
            . ', Código: ' . $validated['zip_code'];
        $inputs['logo'] = $this->saveLogo();
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
