<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
use App\Models\Clients\Receiver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::factory(count: 20)->create();

        foreach($clients as $client){
            FamilyCoreMember::factory(10)->create([
                'client_id' => $client->id
            ]);
            Receiver::factory(10)->create([
                'client_id' => $client->id
            ]);
        }
    }
}
