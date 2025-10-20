<?php

namespace App\Livewire\Packages\CreateMultiple;

use App\Livewire\Forms\Packages\Multiple\StoreForm;
use App\Models\Client;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Main extends Component
{
    public StoreForm $form;

    #[Locked]
    public Client $client;

    public int $packages_count;

    public function mount()
    {
        $client_id = session('warehouse-client-choosed');
        if(is_null($client_id)){
            $this->redirect(route('packages.choose-client'));
            return;
        }
        $this->client = Client::find($client_id);
    }

    public function render()
    {
        return view('livewire.packages.create-multiple.main');
    }

    public function store()
    {
        $this->form->store();
    }

    public function generatePackages()
    {
        $this->dispatch('generated-packages');
    }
}
