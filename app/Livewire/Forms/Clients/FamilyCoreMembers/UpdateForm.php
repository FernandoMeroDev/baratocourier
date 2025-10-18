<?php

namespace App\Livewire\Forms\Clients\FamilyCoreMembers;

use App\Livewire\Forms\Clients\CanSetClient;
use App\Models\Clients\FamilyCoreMember;
use Livewire\Form;

class UpdateForm extends Form
{
    use Attributes, CanSetClient;

    public FamilyCoreMember $member;

    protected function rules(): array
    {
        return [
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'identity_card' => 'required|string|max:10',
        ];
    }

    public function setMember(FamilyCoreMember $member)
    {
        $this->member = $member;
        $this->names = $member->names;
        $this->lastnames = $member->lastnames;
        $this->identity_card = $member->identity_card;
    }

    public function update()
    {
        $validated = $this->validate();
        $this->member->update($validated);
    }
}

