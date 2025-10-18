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

        if($current_user->hasRole('franchisee')){
            $query = $query->join(
                'employees', 'employees.user_id', '=', 'users.id'
            )->where(
                'employees.franchisee_id', $current_user->franchisee->id
            )->select('users.*');
        }

        $users = $query->orderBy('name')->paginate(15, pageName: 'users_page');

        if($users->isEmpty() && $users->currentPage() !== 1)
            $this->resetPage('users_page');

        return $users;
    }
}
