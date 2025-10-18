<?php

namespace App\Livewire\Forms\Clients;

use App\Models\Client;
use Livewire\Attributes\Locked;
use Livewire\Form;

class UpdateForm extends Form
{
    use ClientAttributes, CanSetClient;

    protected function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'identity_card' => 'required|string|max:30',
            'phone_number' => 'required|string|size:10',
            'residential_address' => 'required|string|max:500',
            'email' => 'required|string|max:500',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $this->client->update($validated);
    }
}
