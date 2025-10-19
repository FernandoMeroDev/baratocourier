<?php

namespace App\Livewire\Packages\Create;

use App\Livewire\Forms\Packages\StoreForm;
use App\Models\Client;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Main extends Component
{
    public StoreForm $form;

    #[Locked]
    public Client $client;

    public function mount()
    {
        $client_id = session('warehouse-client-choosed');
        if(is_null($client_id))
            $this->redirect(route('packages.choose-client'));
        else
            $this->client = Client::find($client_id);
    }

    public function render()
    {
        return view('livewire.packages.create.main');
    }

    public function store()
    {
        $this->form->store();
    }
}
