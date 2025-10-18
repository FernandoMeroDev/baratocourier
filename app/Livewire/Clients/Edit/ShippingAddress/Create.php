<?php

namespace App\Livewire\Clients\Edit\ShippingAddress;

use App\Livewire\Forms\Clients\ShippingAddresses\StoreForm;
use App\Models\Client;
use App\Models\Province;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function mount(Client $client)
    {
        $this->form->setClient($client);
    }

    public function render()
    {
        return view('livewire.clients.edit.shipping-address.create', [
            'provinces' => Province::all()
        ]);
    }

    public function store()
    {
        $this->form->store();
        $this->dispatch('created-shipping-address');
    }
}
