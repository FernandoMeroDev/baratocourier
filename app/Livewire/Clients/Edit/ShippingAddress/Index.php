<?php

namespace App\Livewire\Clients\Edit\ShippingAddress;

use App\Models\Client;
use App\Models\Clients\ShippingAddress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Locked]
    public Client $client;

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

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $addresses = null;

        if( ! $current_user->hasRole('administrator') ){
            $addresses = ShippingAddress::join(
                'clients', 'clients.id', '=', 'shipping_addresses.client_id'
            )->where(
                'clients.id', $this->client->id
            )->select('shipping_addresses.*')
                ->paginate(5, pageName: 'addresses_page');
        } else {
            $addresses = ShippingAddress::paginate(15, pageName: 'addresses_page');
        }

        if($addresses->isEmpty() && $addresses->currentPage() !== 1)
            $this->resetPage('addresses_page');

        return $addresses;
    }
}
