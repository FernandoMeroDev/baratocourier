<?php

namespace App\Livewire\Forms\Packages\Multiple;

use Livewire\Form;

class StoreForm extends Form
{
    use Attributes;

    public function store()
    {
        dump($this->all());
    }
}
