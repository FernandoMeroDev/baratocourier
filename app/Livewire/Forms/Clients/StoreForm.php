<?php

namespace App\Livewire\Forms\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    use ClientAttributes;

    protected function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'identity_card' => 'required|string|max:30',
            'phone_number' => 'required|string|size:10',
            'residential_address' => 'required|string|max:500',
            'email' => 'required|string|max:500',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $user = User::find(Auth::user()->id);
        $validated['user_id'] = $user->id;
        $validated['code'] = $this->calcCode($user);
        Client::create($validated);
    }

    private function calcCode(User $user): int
    {
        $last_code = $user->clients()->orderBy('code', 'desc')->value('code') ?? 0;
        return $last_code + 1;
    }
}
