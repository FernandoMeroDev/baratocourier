<?php

namespace App\Livewire\Clients\Edit;

use App\Livewire\Forms\Clients\UpdateForm;
use App\Models\Client;
use Livewire\Component;

class Main extends Component
{
    public UpdateForm $form;

    public function mount(Client $client)
    {
        $this->form->setClient($client);
    }

    public function render()
    {
        return view('livewire.clients.edit.main');
    }

    public function update()
    {
        $this->form->update();
    }

    public function delete()
    {
        $this->form->client->delete();
        $this->redirect(route('clients.index'));
    }
}
