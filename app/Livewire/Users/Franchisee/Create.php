<?php

namespace App\Livewire\Users\Franchisee;

use App\Livewire\Forms\Users\Franchisee\StoreForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public StoreForm $form;

    public function render()
    {
        return view('livewire.users.franchisee.create');
    }

    public function store()
    {
        $this->form->store();
        $this->redirect(route('users.index'));
    }
}
