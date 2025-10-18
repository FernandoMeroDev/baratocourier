<?php

namespace App\Livewire\Forms\Clients\FamilyCoreMembers;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\FamilyCoreMember;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes, CanSetClient;

    protected function rules(): array
    {
        return [
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'identity_card' => 'required|string|max:30',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $validated['client_id'] = $this->client->id;
        FamilyCoreMember::create($validated);
    }
}
