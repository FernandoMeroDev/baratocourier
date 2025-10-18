<?php

namespace App\Livewire\Clients\Edit\Receivers;

use App\Livewire\Forms\Clients\Receivers\UpdateForm;
use App\Models\Client;
use App\Models\Clients\Receiver;
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
        return view('livewire.clients.edit.receivers.edit');
    }

    #[On('edit-receiver')]
    public function openModal($id)
    {
        $receiver = Receiver::find($id);
        // [TODO]: Validate that belongs to current client
        if($receiver){
            if($this->form->client->id == $receiver->client_id){
                $this->form->setReceiver($receiver);
            }
        }
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('edited-receiver');
    }

    public function delete()
    {
        $this->form->receiver->delete();
        $this->dispatch('deleted-receiver');
    }
}
