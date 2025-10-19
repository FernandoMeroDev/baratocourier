<?php

namespace App\Livewire\Clients\Edit\Receivers\Choose;

use App\Livewire\Clients\Edit\Receivers\Index;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public function render()
    {
        return view('livewire.clients.edit.receivers.choose.single', [
            'receivers' => $this->query()
        ]);
    }
}
