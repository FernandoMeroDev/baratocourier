<?php

namespace App\Livewire\Forms\Clients;

use App\Models\Client;
use Livewire\Attributes\Locked;
use Livewire\Form;

class UpdateForm extends Form
{
    use ClientAttributes;

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

    #[Locked]
    public Client $client;

    public function setClient(Client $client)
    {
        $this->client = $client;
        $this->name = $this->client->name;
        $this->identity_card = $this->client->identity_card;
        $this->phone_number = $this->client->phone_number;
        $this->residential_address = $this->client->residential_address;
        $this->email = $this->client->email;
    }

    public function update()
    {
        $validated = $this->validate();
        $this->client->update($validated);
    }
}
