<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers;

use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
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
        return view('livewire.clients.edit.family-core-members.index', [
            'members' => $this->query()
        ]);
    }

    protected function query()
    {
        $search_field = $this->validateColumn($this->search_field);
        $query = FamilyCoreMember::where('client_id', $this->client->id)
            ->where(function($query) {
                $query->where('identity_card', 'LIKE', "%$this->search%")
                    ->orWhere('names', 'LIKE', "%$this->search%")
                    ->orWhere('lastnames', 'LIKE', "%$this->search%")
                    ->orWhereRaw("CONCAT(names, ' ', lastnames) LIKE ?", ["%$this->search%"])
                    ->orWhereRaw("CONCAT(lastnames, ' ', names) LIKE ?", ["%$this->search%"]);
            });

        $members = $query->orderBy($search_field)->paginate(10, pageName: 'members_page');

        if($members->isEmpty() && $members->currentPage() !== 1)
            $this->resetPage('members_page');

        return $members;
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
