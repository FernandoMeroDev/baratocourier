<?php

namespace App\Livewire\Lands;

use App\Models\Lands\Land;
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
        return view('livewire.lands.index', [
            'lands' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $query = Land::join('users', 'lands.user_id', '=', 'users.id')
            ->where(function($query) {
                // [TODO] Add lands.readable_number seach
                $query->where('lands.id', 'LIKE', "%$this->search%")
                    ->where('lands.land_date', 'LIKE', "%$this->search%")
                    ->orWhere('users.name', 'LIKE', "%$this->search%")
                    ->orWhere("users.name", 'LIKE', "%$this->search%")
                    ->orWhere('lands.status', 'LIKE', "%$this->search%");
            });

        if($current_user->hasRole('franchisee'))
            $query = $query->where('user_id', $current_user->id);

        $lands = $query->select('lands.*')
            // ->orderBy('number')
                ->paginate(15, pageName: 'lands_page');

        if($lands->isEmpty() && $lands->currentPage() !== 1)
            $this->resetPage('lands_page');

        return $lands;
    }
}
