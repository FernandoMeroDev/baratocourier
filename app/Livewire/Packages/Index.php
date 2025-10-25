<?php

namespace App\Livewire\Packages;

use App\Models\Packages\Package;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public $search_field;

    public $search_package_status = null;

    public function render()
    {
        return view('livewire.packages.index', [
            'packages' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $search_field = $this->validateColumn($this->search_field);
        $query = Package::join('shops', 'shops.id', '=', 'packages.shop_id')
            ->join('users', 'packages.user_id', '=', 'users.id')
            ->join('waybills', 'waybills.package_id', '=', 'packages.id')
            ->leftJoin('shipments', 'packages.shipment_id', '=', 'shipments.id')
            ->where(function($query) {
                $query->where('shops.name', 'LIKE', "%$this->search%")
                    ->orWhereRaw("CONCAT(packages.client_name, ' ', packages.client_lastname) LIKE ?", ["%$this->search%"])
                    ->orWhere("users.name", 'LIKE', "%$this->search%")
                    ->orWhere("shipments.shipping_date", 'LIKE', "%$this->search%")
                    ->orWhere("shipments.shipment_datetime", 'LIKE', "%$this->search%")
                    ->orWhere("packages.tracking_number", 'LIKE', "%$this->search%")
                    ->orWhere("waybills.status", 'LIKE', "%$this->search%")
                    ->orWhereRaw("CONCAT(
                        packages.guide_domain,
                        LPAD(waybills.waybill_number, 6, '0')
                    ) LIKE ?", ["%$this->search%"]);
            });
        
        if( ! is_null($this->search_package_status) && $this->search_package_status !== '')
                $query = $query->where('waybills.status', Package::$valid_statuses[$this->search_package_status]);
        if($current_user->hasRole('franchisee'))
            $query = $query->where('packages.user_id', $current_user->id);

        $packages = $query->select('packages.*')->orderBy($search_field)
            ->paginate(15, pageName: 'packages_page');

        if($packages->isEmpty() && $packages->currentPage() !== 1)
            $this->resetPage('packages_page');

        return $packages;
    }

    protected function validateColumn($column): string
    {
        return match($column){
            'created_at' => 'created_at',
            'shop_name' => 'shops.name',
            'waybill_redable_number' => 'waybills.waybill_number',
            'client_name' => 'client_name',
            'estimated_date' => 'shipments.shipping_date',
            'tracking_number' => 'tracking_number',
            'status' => 'status',
            default => 'created_at'
        };
    }
}
