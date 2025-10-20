<?php

namespace App\Livewire\Clients\Edit\Receivers;

use App\Models\Client;
use App\Models\Clients\Receiver;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $page_name = 'receivers_page';

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

    protected function query()
    {
        $search_field = $this->validateColumn($this->search_field);
        $query = Receiver::where('client_id', $this->client->id)
            ->where(function($query) {
                $query->where('identity_card', 'LIKE', "%$this->search%")
                    ->orWhere('names', 'LIKE', "%$this->search%")
                    ->orWhere('lastnames', 'LIKE', "%$this->search%")
                    ->orWhereRaw("CONCAT(names, ' ', lastnames) LIKE ?", ["%$this->search%"])
                    ->orWhereRaw("CONCAT(lastnames, ' ', names) LIKE ?", ["%$this->search%"]);
            });

        $receivers = $query->orderBy($search_field)->paginate(10, pageName: $this->page_name);

        if($receivers->isEmpty() && $receivers->currentPage() !== 1)
            $this->resetPage($this->page_name);

        return $receivers;
    }

    protected function validateColumn($column): string
    {
        return match($column){
            'names' => 'names',
            'lastnames' => 'lastnames',
            'identity_card' => 'identity_card',
            default => 'names'
        };
    }
}
