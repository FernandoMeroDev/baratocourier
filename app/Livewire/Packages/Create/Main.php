<?php

namespace App\Livewire\Packages\Create;

use App\Livewire\Forms\Packages\StoreForm;
use App\Models\Client;
use App\Models\Packages\Category;
use App\Models\Shop;
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
        if(is_null($client_id)){
            $this->redirect(route('packages.choose-client'));
            return;
        }
        $this->client = Client::find($client_id);
    }

    public function render()
    {
        return view('livewire.packages.create.main', [
            'shops' => Shop::all(),
            'categories' => Category::all()
        ]);
    }
}
