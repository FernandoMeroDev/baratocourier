<?php

namespace App\Livewire\Forms\Users\Employee;

use Livewire\Attributes\Validate;
use App\Livewire\Forms\Users\StoreForm as BaseStoreForm;

class StoreForm extends BaseStoreForm
{
    public function rules(): array
    {
        $rules = parent::rules();
        // Add Rules
        return $rules;
    }

    public function store()
    {
        $stored = parent::store();
        extract($stored); // $validated, $user
        // Add Save Logic
        // Employee::create($validated);
    }
}
