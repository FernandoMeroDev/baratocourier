<?php

namespace App\Livewire\Packages\CreateMultiple;

use App\Livewire\Forms\Packages\Multiple\StoreForm;
use App\Models\Client;
use App\Models\Packages\Category;
use App\Models\Packages\ShippingMethod;
use App\Models\Shop;
use Livewire\Attributes\Locked;
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
        return view('livewire.packages.create-multiple.main', [
            'shops' => Shop::all(),
            'categories' => Category::all(),
            'shipping_methods' => ShippingMethod::all()
        ]);
    }

    public function store()
    {
        $this->form->store($this->client);
    }

    public function generatePackages()
    {
        $this->dispatch('generated-packages');
    }
}
