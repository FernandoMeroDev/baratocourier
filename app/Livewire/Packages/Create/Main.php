<?php

namespace App\Livewire\Packages\Create;

use App\Livewire\Forms\Packages\StoreForm;
use App\Models\Client;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Main extends Component
{
    public StoreForm $form;

    #[Locked]
    public Client $client;

    public function mount()
    {
        $client_id = session('warehouse-client-choosed');
        if(is_null($client_id)){
            $this->redirect(route('packages.choose-client'));
            return;
        }
        $this->client = Client::find($client_id);
        $this->form->person_type = session('warehouse-person-type-choosed');
        $this->form->person_id = session('warehouse-person-id-choosed');
    }

    public function render()
    {
        return view('livewire.packages.create.main');
    }

    public function store()
    {
        $this->form->store();
    }

    #[Renderless]
    public function savePersonSelected($person_type, $person_id)
    {
        session(['warehouse-person-type-choosed' => $person_type]);
        session(['warehouse-person-id-choosed' => $person_id]);
    }
}
