<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\StoreForm;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.users.create');
    }

    public function store()
    {
        $this->form->store();
        $this->redirect(route('users.index'));
    }
}
