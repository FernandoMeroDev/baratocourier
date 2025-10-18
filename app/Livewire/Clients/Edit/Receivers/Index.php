<?php

namespace App\Livewire\Clients\Edit\Receivers;

use App\Models\Client;
use App\Models\Clients\Receiver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public $search_field;

    #[Locked]
    public Client $client;

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function render()
    {
        return view('livewire.clients.edit.receivers.index', [
            'receivers' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $search_field = $this->validateColumn($this->search_field);
        $query = Receiver::where($search_field, 'LIKE', "%$this->search%");

        if($current_user->hasRole('franchisee'))
            $query = $query->where('client_id', $this->client->id);

        $receivers = $query->orderBy($search_field)->paginate(10, pageName: 'receivers_page');

        if($receivers->isEmpty() && $receivers->currentPage() !== 1)
            $this->resetPage('receivers_page');

        return $receivers;
    }

    private function validateColumn($column): string
    {
        return match($column){
            'names' => 'names',
            'lastnames' => 'lastnames',
            'identity_card' => 'identity_card',
            default => 'identity_card'
        };
    }
}
