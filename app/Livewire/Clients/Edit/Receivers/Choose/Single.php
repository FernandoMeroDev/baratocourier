<?php

namespace App\Livewire\Clients\Edit\Receivers\Choose;

use App\Livewire\Clients\Edit\Receivers\Index;
use App\Models\Client;
use InvalidArgumentException;
use Livewire\Attributes\Modelable;

class Single extends Index
{
    #[Modelable]
    public $choosed_id;

    public $i;

    public function boot()
    {
        if(isset($this->i))
            $this->page_name . '-' . $this->i;
    }

    public function mount(mixed $data)
    {
        if(is_array($data)){
            $this->client = $data['client'];
            $this->i = $data['i'];
        } elseif($data instanceof Client) {
            $this->client = $data;
        }  else {
            throw new InvalidArgumentException('Missed client or i componen props');
        }
    }

    public function render()
    {
        return view('livewire.clients.edit.receivers.choose.single', [
            'receivers' => $this->query()
        ]);
    }
}
