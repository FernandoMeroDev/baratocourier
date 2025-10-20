<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers\Choose;

use App\Livewire\Clients\Edit\FamilyCoreMembers\Index;
use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
use InvalidArgumentException;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public $i;

    public $members_selected = [];

    public function mount(mixed $data)
    {
        if(is_array($data)){
            $this->client = $data['client'];
            $this->i = $data['i'];
        } elseif($data instanceof Client) {
            $this->client = $data;
        } else {
            throw new InvalidArgumentException('Missed client or i component props');
        }
    }

    public function render()
    {
        return view('livewire.clients.edit.family-core-members.choose.single', [
            'members' => $this->query()
        ]);
    }

    public function refresh() {}

    protected function query()
    {
        $search_field = $this->validateColumn($this->search_field);
        $query = FamilyCoreMember::where('client_id', $this->client->id);
        if(isset($this->members_selected))
            $query = $query->whereNotIn('id', $this->members_selected);
        $query = $query->where(function($query) {
            $query->where('identity_card', 'LIKE', "%$this->search%")
                ->orWhere('names', 'LIKE', "%$this->search%")
                ->orWhere('lastnames', 'LIKE', "%$this->search%")
                ->orWhereRaw("CONCAT(names, ' ', lastnames) LIKE ?", ["%$this->search%"])
                ->orWhereRaw("CONCAT(lastnames, ' ', names) LIKE ?", ["%$this->search%"]);
        });

        $members = $query->orderBy($search_field)->paginate(10, pageName: $this->page_name);

        if($members->isEmpty() && $members->currentPage() !== 1)
            $this->resetPage($this->page_name);

        return $members;
    }

    public function memberSelected($id)
    {
        $this->members_selected[] = $id;
    }
}
