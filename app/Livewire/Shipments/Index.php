<?php

namespace App\Livewire\Shipments;

use App\Models\Shipments\Shipment;
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
        return view('livewire.shipments.index', [
            'shipments' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $query = Shipment::join('users', 'shipments.user_id', '=', 'users.id')
            ->join('shipment_types', 'shipments.shipment_type_id', '=', 'shipment_types.id')
            ->where(function($query) {
                $query->where('shipments.number', 'LIKE', "%$this->search%")
                    ->orWhere('shipments.shipment_datetime', 'LIKE', "%$this->search%")
                    ->orWhere("users.name", 'LIKE', "%$this->search%")
                    ->orWhere('shipments.status', 'LIKE', "%$this->search%")
                    ->orWhere('shipment_types.name', 'LIKE', "%$this->search%");
            });

        if($current_user->hasRole('franchisee'))
            $query = $query->where('user_id', $current_user->id);

        $shipments = $query->select('shipments.*')
            ->orderBy('number')->paginate(15, pageName: 'shipments_page');

        if($shipments->isEmpty() && $shipments->currentPage() !== 1)
            $this->resetPage('shipments_page');

        return $shipments;
    }
}
