<?php

namespace App\Livewire\Users\Franchisee\Edit;

use App\Livewire\Forms\Users\Franchisee\UpdateForm;
use App\Models\User\Franchisee;
use Livewire\Component;
use Livewire\WithFileUploads;

class Main extends Component
{
    use WithFileUploads;

    public UpdateForm $form;

    public function mount(Franchisee $franchisee)
    {
        $this->form->setUser($franchisee->user);
        $this->form->setFranchisee($franchisee);
    }

    public function render()
    {
        return view('livewire.users.franchisee.edit.main');
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('edited-franchisee');
    }

    public function delete()
    {
        $this->form->user->delete();
        $this->redirect(route('users.index'));
    }
}
