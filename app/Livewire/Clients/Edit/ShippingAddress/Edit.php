<?php

namespace App\Livewire\Clients\Edit\ShippingAddress;

use App\Livewire\Forms\Clients\ShippingAddresses\UpdateForm as UpdateForm;
use App\Models\Client;
use App\Models\Clients\ShippingAddress;
use App\Models\Province;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public UpdateForm $form;

    public function mount(Client $client)
    {
        $this->form->setClient($client, set_attributes: false);
    }

    public function render()
    {
        return view('livewire.clients.edit.shipping-address.edit', [
            'provinces' => Province::all()
        ]);
    }

    #[On('edit-shipping-address')]
    public function openModal($id)
    {
        $shippingAddress = ShippingAddress::find($id);
        if($shippingAddress){
            if($this->form->client->id == $shippingAddress->client_id){
                $this->form->setShippingAddress($shippingAddress);
            }
        }
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('edited-shipping-address');
    }

    public function delete()
    {
        $this->form->shipping_address->delete();
        $this->dispatch('deleted-shipping-address');
    }
}
