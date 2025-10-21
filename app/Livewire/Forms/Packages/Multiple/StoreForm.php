<?php

namespace App\Livewire\Forms\Packages\Multiple;

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

    protected function rules()
    {
        return [
            'tracking_number' => 'string',
            'shop_id' => 'required|string',
            'reference' => 'string',
            'shipping_method_id' => 'required|integer|exists:shipping_methods,id',
            'shipping_address_id' => 'required|string',
            'category_id' => 'required|integer|exists:package_categories,id',
            // Variables for each package
            'weights' => 'required|array',
            'prices' => 'required|array',
            'person_types' => 'required|array',
            'person_ids' => 'required|array',
            'items_counts' => 'required|array',
            'descriptions' => 'required|array',
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
        for($i = 0; $i < count($validated['weights']); $i++){
            $waybill = Waybill::create([
                'price' => $validated['prices'][$i],
                'weight' => $validated['weights'][$i],
                'items_count' => $validated['items_counts'][$i],
                'description' => $validated['descriptions'][$i],
                'status' => 'Bodega USA',
                'package_id' => $package->id,
            ]);
            $personal_data = [];
            $person = null;
            switch($validated['person_types'][$i]){
                case 'client':
                    $person = Client::find($validated['person_ids'][$i]);
                    $personal_data['name'] = $person->name;
                    $personal_data['lastname'] = $person->lastname;
                    $personal_data['phone_number'] = $person->phone_number;
                    break;
                case 'receiver':
                    $person = Receiver::find($validated['person_ids'][$i]);
                    $personal_data['name'] = $person->names;
                    $personal_data['lastname'] = $person->lastnames;
                    $personal_data['phone_number'] = $person->phone_number ?? 'Ninguno';
                    break;
                case 'family_core_member':
                    $person = FamilyCoreMember::find($validated['person_ids'][$i]);
                    $personal_data['name'] = $person->names;
                    $personal_data['lastname'] = $person->lastnames;
                    $personal_data['phone_number'] = $person->phone_number ?? 'Ninguno';
                    break;
            }
            $personal_data['identity_card'] = $person->identity_card;
            $personal_data['person_type'] = $validated['person_types'][$i];
            $personal_data['waybill_id'] = $waybill->id;
            PersonalData::create($personal_data);
        }
        return $package;
    }
}
