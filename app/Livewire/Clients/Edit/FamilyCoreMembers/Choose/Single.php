<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers\Choose;

use App\Livewire\Clients\Edit\FamilyCoreMembers\Index;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public function render()
    {
        return view('livewire.clients.edit.family-core-members.choose.single', [
            'members' => $this->query()
        ]);
    }
}
