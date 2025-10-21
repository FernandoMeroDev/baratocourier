<?php

namespace App\Livewire\Forms\Packages;

use App\Models\Client;
use App\Models\Clients\FamilyCoreMember;
use App\Models\Clients\Receiver;
use App\Models\Clients\ShippingAddress;
use App\Models\Packages\Package;
use App\Models\Packages\Waybills\PersonalData;
use App\Models\Packages\Waybills\Waybill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes;

    public function store(Client $client)
    {
        $validated = $this->all(); // Dummy Validation
        $user = User::find(Auth::user()->id);
        $shippingAddress = ShippingAddress::find($validated['shipping_address_id']);
        $package = Package::create([
            'tracking_number' => $validated['tracking_number'],
            'courier_name' => $user->franchisee->courier_name,
            'logo' => $user->franchisee->logo ?? 'No registrado',
            'address' => $shippingAddress->completeAddress(),
            'reference'  => $validated['reference'],
            'guide_domain' => $user->franchisee->guide_domain,
            'client_domain' => $user->franchisee->client_domain,
            'client_code' => $client->code,
            'shop_id' => $validated['shop_id'],
            'package_category_id' => $validated['category_id'],
            'shipping_method_id'  => $validated['shipping_method_id'],
            'user_id' => $user->id
        ]);
        $waybill = Waybill::create([
            'price' => $validated['price'],
            'weight' => $validated['weight'],
            'items_count' => $validated['items_count'],
            'description' => $validated['description'],
            'status' => 'Bodega USA',
            'package_id' => $package->id,
        ]);
        $personal_data = [];
        $person = null;
        switch($validated['person_type']){
            case 'client':
                $person = Client::find($validated['person_id']);
                $personal_data['name'] = $person->name;
                $personal_data['lastname'] = $person->lastname;
                $personal_data['phone_number'] = $person->phone_number;
                break;
            case 'receiver':
                $person = Receiver::find($validated['person_id']);
                $personal_data['name'] = $person->names;
                $personal_data['lastname'] = $person->lastnames;
                $personal_data['phone_number'] = $person->phone_number ?? 'Ninguno';
                break;
            case 'family_core_member':
                $person = FamilyCoreMember::find($validated['person_id']);
                $personal_data['name'] = $person->names;
                $personal_data['lastname'] = $person->lastnames;
                $personal_data['phone_number'] = $person->phone_number ?? 'Ninguno';
                break;
        }
        $personal_data['identity_card'] = $person->identity_card;
        $personal_data['person_type'] = $validated['person_type'];
        $personal_data['waybill_id'] = $waybill->id;
        $personalData = PersonalData::create($personal_data);
    }
}
