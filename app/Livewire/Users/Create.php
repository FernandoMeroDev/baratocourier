<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\StoreForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.users.create', [
            'roles' => $this->getRoles()
        ]);
    }

    public function store()
    {
        $this->form->store();
        $this->redirect(route('users.index'));
    }

    private function getRoles(): Collection
    {
        $forbbiden = ['administrator'];
        // $user = User::find(Auth::user()->id);
        $roles = Role::whereNotIn('name', $forbbiden)->get();
        return $roles;
    }
}
