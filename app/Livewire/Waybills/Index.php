<?php

namespace App\Livewire\Waybills;

use App\Livewire\Traits\CanPaginateManually;
use App\Models\Packages\Waybills\Waybill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, CanPaginateManually;

    public $search;
    
    public function render()
    {
        return view('livewire.waybills.index', [
            'waybills' => $this->query()
        ]);
    }

    private function query()
    {
        $current_user = User::find(Auth::user()->id);
        $query = Waybill::join('packages', 'packages.id', '=', 'waybills.package_id')
            ->join('users', 'packages.user_id', '=', 'users.id');
            // ->where(function($query) {
            //     $query->where('packages.created_at', 'LIKE', "%$this->search%")
            //         ->orWhereRaw("CONCAT(waybills.weight, ' Lb') LIKE ?", ["%$this->search%"])
            //         ->orWhere("users.name", 'LIKE', "%$this->search%");
            // });

        if($current_user->hasRole('franchisee'))
            $query = $query->where('packages.user_id', $current_user->id);

        $waybills = $query->select('waybills.*')->orderBy('waybill_number')->get();
        
        if( ! is_null($this->search)){
            $search = $this->search;
            $waybills = $waybills->filter(function($waybill, int $key) use ($search) {
                $pattern = "%$search%";
                // Escapar caracteres especiales de regex
                $pattern = preg_quote($pattern, '/');
                // Reemplazar comodines SQL por sus equivalentes en regex
                $pattern = str_replace(['%', '_'], ['.*', '.'], $pattern);
                // Añadir delimitadores e indicadores de coincidencia completa;
                return preg_match('/^' . $pattern . '$/i', $waybill->readable_number()) === 1
                    || preg_match('/^' . $pattern . '$/i', $waybill->package->created_at) === 1
                    || preg_match('/^' . $pattern . '$/i', $waybill->package->user->name) === 1
                    || preg_match('/^' . $pattern . '$/i', $waybill->weight . ' Lb') === 1;
            });
        }

        $waybills = $this->paginate($waybills, 15, 'waybills_page');

        if($waybills->isEmpty() && $waybills->currentPage() !== 1)
            $this->resetPage('waybills_page');

        return $waybills;
    }
}
