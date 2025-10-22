<?php

namespace App\Livewire\Users\Franchisee\Edit;

use App\Livewire\Forms\Users\Franchisee\Waybill\UpdateForm;
use App\Models\User\Franchisee;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Waybill extends Component
{
    #[Locked]
    public Franchisee $franchisee;

    public UpdateForm $form;

    public function mount(Franchisee $franchisee)
    {
        $this->franchisee =  $franchisee;
    }

    public function render()
    {
        return view('livewire.users.franchisee.edit.waybill');
    }

    public function restoreDefaultStyles()
    {
        $this->franchisee->update([
            'waybill_styles' => json_encode(Franchisee::defaultWaybillStyles())
        ]);
        $this->redirect(route('users.franchisee.edit', $this->franchisee->id));
    }
}
