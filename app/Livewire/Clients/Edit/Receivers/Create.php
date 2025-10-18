<?php

namespace App\Livewire\Clients\Edit\Receivers;

use App\Livewire\Forms\Clients\Receivers\StoreForm;
use App\Models\Client;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function mount(Client $client)
    {
        $this->form->setClient($client, set_attributes: false);
    }

    public function render()
    {
        return view('livewire.clients.edit.receivers.create');
    }

    public function store()
    {
        $this->form->store();
        $this->dispatch('created-receiver');
    }
}
