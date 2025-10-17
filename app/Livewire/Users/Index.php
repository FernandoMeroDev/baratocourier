<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        return view('livewire.users.index', [
            'users' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $query = User::where('name', 'LIKE', "%$this->search%");

        if($current_user->hasRole('franchisee'))
            // [TODO] Consultar los empleados que han sido creados por este franquiciado
            $query = $query->where('id', $current_user->id);

        $users = $query->orderBy('name')->paginate(15, pageName: 'users_page');

        if($users->isEmpty() && $users->currentPage() !== 1)
            $this->resetPage('users_page');

        return $users;
    }
}
