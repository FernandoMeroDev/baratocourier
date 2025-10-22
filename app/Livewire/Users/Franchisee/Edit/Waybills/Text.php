<?php

namespace App\Livewire\Users\Franchisee\Edit\Waybills;

use App\Models\User\Franchisee;

class Text extends Block
{
    public string $font_style;

    public string $font_weight;

    public function mount(Franchisee $franchisee, string $field, string $label)
    {
        $styles = parent::mount($franchisee, $field, $label);
        $this->font_style = $styles->{$field}->font_style;
        $this->font_weight = $styles->{$field}->font_weight;
    }

    public function render()
    {
        return view('livewire.users.franchisee.edit.waybills.text');
    }
}
