<?php

namespace App\Livewire\Clients\Edit\ShippingAddress;

use App\Models\Client;
use App\Models\Clients\ShippingAddress;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Locked]
    public Client $client;

    public $search;

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function render()
    {
        return view('livewire.clients.edit.shipping-address.index', [
            'addresses' => $this->query()
        ]);
    }

    protected function query()
    {
        $addresses = null;

        $addresses = ShippingAddress::join(
            'clients', 'clients.id', '=', 'shipping_addresses.client_id'
        )->join(
            'provinces', 'provinces.id', '=', 'shipping_addresses.province_id'
        )->where(
            'clients.id', $this->client->id
        )->where(function($query) {
                $query->where('shipping_addresses.line_1', 'LIKE', "%$this->search%")
                    ->orWhere('shipping_addresses.line_2', 'LIKE', "%$this->search%")
                    ->orWhere('shipping_addresses.city_name', 'LIKE', "%$this->search%")
                    ->orWhere('shipping_addresses.zip_code', 'LIKE', "%$this->search%")
                    ->orWhere('provinces.name', 'LIKE', "%$this->search%")
                    ->orWhereRaw("CONCAT(
                        shipping_addresses.line_1, ', ', 
                        shipping_addresses.line_2, ', ', 
                        shipping_addresses.city_name, ', ', 
                        provinces.name, ', ', 
                        provinces.name, ', Código: ', 
                        shipping_addresses.zip_code, '.'
                    ) LIKE ?", ["%$this->search%"]);
        })->select('shipping_addresses.*')
            ->paginate(5, pageName: 'addresses_page');

        if($addresses->isEmpty() && $addresses->currentPage() !== 1)
            $this->resetPage('addresses_page');

        return $addresses;
    }
}
