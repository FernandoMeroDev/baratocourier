<?php

namespace App\Livewire\Users\Franchisee\Edit\Waybills;

use App\Models\User\Franchisee;
use Livewire\Component;

class Block extends Component
{
    public $label;

    public $field;

    public Franchisee $franchisee;

    // Field Styles
    public int $position;

    public int $size;

    public string $align;

    public int $margin_top;

    public int $margin_bottom;

    public function mount(Franchisee $franchisee, string $field, string $label)
    {
        $this->label = $label;
        $this->field = $field;
        $this->franchisee = $franchisee;
        $styles = json_decode($this->franchisee->waybill_styles);
        $this->position = $styles->{$field}->position;
        $this->size = $styles->{$field}->size;
        $this->align = $styles->{$field}->align;
        $this->margin_top = $styles->{$field}->margin_top;
        $this->margin_bottom = $styles->{$field}->margin_bottom;
        return $styles;
    }

    public function render()
    {
        return view('livewire.users.franchisee.edit.waybills.block');
    }

    public function updated($name, $value)
    {
        // $this->validate(); // Run Validation Rules, you can pass them via mount method
        $styles = json_decode($this->franchisee->waybill_styles);
        $styles->{$this->field}->{$name} = $value;
        $this->franchisee->update([
            'waybill_styles' => json_encode($styles)
        ]);
    }
}
