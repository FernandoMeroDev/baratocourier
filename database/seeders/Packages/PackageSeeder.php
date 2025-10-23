<?php

namespace Database\Seeders\Packages;

use App\Models\Packages\Package;
use App\Models\Packages\Waybills\PersonalData;
use App\Models\Packages\Waybills\Waybill;
use App\Models\User\Franchisee;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $franchisee = Franchisee::all()->get(0);
        $packages = Package::factory(10)->create([
            'user_id' => $franchisee->user->id
        ]);
        foreach($packages as $package){
            $waybills = Waybill::factory(5)->state(new Sequence(
                fn($sequence) => ['waybill_number' => Franchisee::calcWaybillNumber($franchisee),]
            ))->create([
                'package_id' => $package->id,
            ]);
            foreach($waybills as $waybill)
                PersonalData::create([
                    'name' => 'Nombre1 Nombre2',
                    'lastname' => 'Apellido1 Apellido2',
                    'phone_number' => '0999999999',
                    'identity_card' => '1350000000',
                    'person_type' => 'client',
                    'waybill_id' => $waybill->id,
                ]);
        }
    }
}
