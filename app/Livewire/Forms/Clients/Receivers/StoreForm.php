<?php

namespace App\Livewire\Forms\Clients\Receivers;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\Receiver;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes, CanSetClient;

    protected function rules(): array
    {
        return [
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'identity_card' => 'required|string|max:30',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $validated['client_id'] = $this->client->id;
        Receiver::create($validated);
    }
}
