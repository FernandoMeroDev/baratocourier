<?php

namespace App\Livewire\Forms\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreForm extends Form
{
    public $name;

    public $identity_card;

    public $phone_number;

    public $residential_address;

    public $email;

    protected function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'identity_card' => 'required|string|max:30',
            'phone_number' => 'required|string|size:10',
            'residential_address' => 'required|string|max:500',
            'email' => 'required|string|max:500',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $validated['user_id'] = Auth::user()->id;
        Client::create($validated);
    }
}
