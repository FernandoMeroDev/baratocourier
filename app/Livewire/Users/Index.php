<?php

namespace App\Livewire\Users;

use App\Models\User;
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
        $users = User::where('name', 'LIKE', "%$this->search%")
            ->orderBy('name')->paginate(15, pageName: 'users_page');

        if($users->isEmpty() && $users->currentPage() !== 1)
            $this->resetPage('users_page');

        return $users;
    }
}
