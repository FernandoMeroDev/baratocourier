<?php

namespace App\Livewire\Forms\Clients\Receivers;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\Receiver;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
    use Attributes, CanSetClient;

    public Receiver $receiver;

    protected function rules(): array
    {
        return [
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'identity_card' => 'required|string|max:10',
        ];
    }

    public function setReceiver(Receiver $receiver)
    {
        $this->receiver = $receiver;
        $this->names = $receiver->names;
        $this->lastnames = $receiver->lastnames;
        $this->identity_card = $receiver->identity_card;
    }

    public function update()
    {
        $validated = $this->validate();
        $this->receiver->update($validated);
    }
}
