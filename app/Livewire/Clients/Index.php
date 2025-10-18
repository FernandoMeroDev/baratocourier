<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public $search_field;

    public function render()
    {
        return view('livewire.clients.index', [
            'clients' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        // $query = User::where('name', 'LIKE', "%$this->search%");
        $search_field = $this->validateColumn($this->search_field);
        $query = Client::where($search_field, 'LIKE', "%$this->search%");

        if($current_user->hasRole('franchisee'))
            $query = $query->where('user_id', $current_user->id);

        $clients = $query->orderBy($search_field)->paginate(15, pageName: 'clients_page');

        if($clients->isEmpty() && $clients->currentPage() !== 1)
            $this->resetPage('clients_page');

        return $clients;
    }

    private function validateColumn($column): string
    {
        return match($column){
            'name' => 'name',
            'lastname' => 'lastname',
            'identity_card' => 'identity_card',
            'phone_number' => 'phone_number',
            'residential_address' => 'residential_address',
            'email' => 'email',
            default => 'identity_card'
        };
    }
}
