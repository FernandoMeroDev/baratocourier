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
use App\Models\User\Franchisee;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    use Attributes;

    protected function rules()
    {
        return [
            'tracking_number' => 'nullable|string',
            'shop_id' => 'required|string',
            'reference' => 'nullable|string',
            'shipping_method_id' => 'required|integer|exists:shipping_methods,id',
            'shipping_address_id' => 'required|string',
            'category_id' => 'required|integer|exists:package_categories,id',
            // Variables for each package
            'weight' => 'required|decimal:0,2',
            'price' => 'required|decimal:0,2',
            'person_type' => 'required|string',
            'person_id' => 'required|integer',
            'items_count' => 'required|integer',
            'description' => 'required|string',
        ];
    }

    public function store(Client $client)
    {
        $validated = $this->validate(); // Dummy Validation
        $user = User::find(Auth::user()->id);
        $shippingAddress = ShippingAddress::find($validated['shipping_address_id']);
        $package = Package::create([
            'tracking_number' => $validated['tracking_number'],
            'courier_name' => $user->franchisee->courier_name,
            'logo' => $user->franchisee->logo ?? 'No registrado',
            'shipping_address' => $shippingAddress->jsonAddress(),
            'reference'  => $validated['reference'],
            'guide_domain' => $user->franchisee->guide_domain,
            'client_domain' => $user->franchisee->client_domain,
            'client_code' => $client->code,
            'client_identity_card' => $client->identity_card,
            'client_name' => $client->name,
            'client_lastname' => $client->lastname,
            'shop_id' => $validated['shop_id'],
            'package_category_id' => $validated['category_id'],
            'shipping_method_id'  => $validated['shipping_method_id'],
            'user_id' => $user->id
        ]);
        $waybill = Waybill::create([
            'waybill_number' => Franchisee::calcWaybillNumber($user->franchisee),
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
                break;
            case 'receiver':
                $person = Receiver::find($validated['person_id']);
                $personal_data['name'] = $person->names;
                $personal_data['lastname'] = $person->lastnames;
                break;
            case 'family_core_member':
                $person = FamilyCoreMember::find($validated['person_id']);
                $personal_data['name'] = $person->names;
                $personal_data['lastname'] = $person->lastnames;
                break;
        }
        $personal_data['phone_number'] = $user->franchisee->phone_number;
        $personal_data['identity_card'] = $person->identity_card;
        $personal_data['person_type'] = $validated['person_type'];
        $personal_data['waybill_id'] = $waybill->id;
        PersonalData::create($personal_data);
        return $package;
    }
}
