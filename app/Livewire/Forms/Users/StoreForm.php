<?php

namespace App\Livewire\Forms\Users;

use App\Models\User;
use Livewire\Form;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class StoreForm extends Form
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        event(new Registered(($user = User::create($validated))));
        return ['validated' => $validated, 'user' => $user];
    }
}
