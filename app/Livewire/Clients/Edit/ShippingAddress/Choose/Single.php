<?php

namespace App\Livewire\Clients\Edit\ShippingAddress\Choose;

use App\Livewire\Clients\Edit\ShippingAddress\Index;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public function render()
    {
        return view('livewire.clients.edit.shipping-address.choose.single', [
            'addresses' => $this->query()
        ]);
    }
}
