<?php

namespace App\Livewire\Forms\Clients;

use App\Models\Client;
use Livewire\Attributes\Locked;

trait CanSetClient
{
    #[Locked]
    public Client $client;

    public function setClient(Client $client)
    {
        $this->client = $client;
        $this->name = $this->client->name;
        $this->lastname = $this->client->lastname;
        $this->identity_card = $this->client->identity_card;
        $this->phone_number = $this->client->phone_number;
        $this->residential_address = $this->client->residential_address;
        $this->email = $this->client->email;
    }
}