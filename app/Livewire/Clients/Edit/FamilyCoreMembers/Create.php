<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers;

use App\Livewire\Forms\Clients\FamilyCoreMembers\StoreForm;
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
        return view('livewire.clients.edit.family-core-members.create');
    }

    public function store()
    {
        $this->form->store();
        $this->dispatch('created-family-core-member');
    }
}
