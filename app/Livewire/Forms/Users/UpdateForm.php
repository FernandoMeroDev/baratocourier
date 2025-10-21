<?php

namespace App\Livewire\Forms\Users;

use App\Models\User;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;

class UpdateForm extends Form
{
    #[Locked]
    public User $user;

    public string $name = '';

    public string $email = '';

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user->id),
            ],
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $this->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        return $validated;
    }
}
