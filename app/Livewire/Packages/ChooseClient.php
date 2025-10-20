<?php

namespace App\Livewire\Packages;

use App\Livewire\Clients\Index;
use Livewire\Attributes\Validate;

class ChooseClient extends Index
{
    protected $per_page = 5;

    #[Validate('required|exists:clients,id')]
    public $choosed_id;

    public function render()
    {
        return view('livewire.packages.choose-client', [
            'clients' => $this->query()
        ]);
    }

    public function choose()
    {
        $this->validate();
        session(['warehouse-client-choosed' => $this->choosed_id]);
        $this->redirect(route('packages.create'));
    }
}
