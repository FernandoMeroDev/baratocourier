<?php

namespace App\Livewire\Forms\Packages;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes;

    public function store()
    {
        dump($this->all());
    }
}
