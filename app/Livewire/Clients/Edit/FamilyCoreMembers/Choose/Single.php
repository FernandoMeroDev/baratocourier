<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers\Choose;

use App\Livewire\Clients\Edit\FamilyCoreMembers\Index;
use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public $i;

    public $members_selected = [];

    public $use_all;

    public $search_field = 'last_use_at';

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
        if($this->use_all)
            $query = FamilyCoreMember::join(
                'clients', 'clients.id', '=', 'client_family_core_members.id'
            )->where('clients.user_id', Auth::user()->id)
            ->select('client_family_core_members.*');
        else
            $query = FamilyCoreMember::where('client_id', $this->client->id);
        if(isset($this->members_selected))
            $query = $query->whereNotIn('client_family_core_members.id', $this->members_selected);
        $query = $query->where(function($query) {
            $query->where('client_family_core_members.identity_card', 'LIKE', "%$this->search%")
                ->orWhere('names', 'LIKE', "%$this->search%")
                ->orWhere('lastnames', 'LIKE', "%$this->search%")
                ->orWhereRaw("CONCAT(names, ' ', lastnames) LIKE ?", ["%$this->search%"])
                ->orWhereRaw("CONCAT(lastnames, ' ', names) LIKE ?", ["%$this->search%"]);
        });

        $members = $query->orderBy($search_field, 'desc')->paginate(10, pageName: $this->page_name);

        if($members->isEmpty() && $members->currentPage() !== 1)
            $this->resetPage($this->page_name);

        return $members;
    }

    public function memberSelected($id)
    {
        $this->members_selected[] = $id;
    }

    public function toggleUseAll()
    {
        $this->use_all = ! $this->use_all;
    }
}
