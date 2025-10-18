<?php

namespace App\Livewire\Clients\Edit\FamilyCoreMembers;

use App\Livewire\Forms\Clients\FamilyCoreMembers\UpdateForm;
use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public UpdateForm $form;

    public function mount(Client $client)
    {
        $this->form->setClient($client, set_attributes: false);
    }

    public function render()
    {
        return view('livewire.clients.edit.family-core-members.edit');
    }

    #[On('edit-family-core-member')]
    public function openModal($id)
    {
        $member = FamilyCoreMember::find($id);
        if($member){
            if($this->form->client->id == $member->client_id){
                $this->form->setMember($member);
            }
        }
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('edited-family-core-member');
    }

    public function delete()
    {
        $this->form->member->delete();
        $this->dispatch('deleted-family-core-member');
    }
}
