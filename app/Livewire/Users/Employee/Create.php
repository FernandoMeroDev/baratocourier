<?php

namespace App\Livewire\Users\Employee;

use App\Livewire\Forms\Users\Employee\StoreForm;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.users.employee.create');
    }

    public function store()
    {
        $this->form->store();
        $this->redirect(route('users.index'));
    }
}
