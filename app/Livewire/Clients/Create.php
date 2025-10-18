<?php

namespace App\Livewire\Clients;

use App\Livewire\Forms\Clients\StoreForm;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.clients.create');
    }

    public function store()
    {
        $this->form->store();
        $this->dispatch('created-client');
    }
}
