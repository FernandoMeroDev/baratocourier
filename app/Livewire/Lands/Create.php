<?php

namespace App\Livewire\Lands;

use App\Models\Lands\Land;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $land_date;

    public function mount()
    {
        $this->land_date = date('Y-m-d', now()->timestamp);
    }

    public function render()
    {
        return view('livewire.lands.create');
    }

    public function store()
    {
        $land = Land::create([
            'status' => Land::$valid_statuses['unlanded'],
            'land_date' => $this->land_date,
            'user_id' => Auth::user()->id
        ]);
        $this->redirect(route('lands.land', $land->id));
    }
}
