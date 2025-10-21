<?php

namespace Database\Seeders\Packages;

use App\Models\Packages\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    private array $methods = [
        ['name' => 'Servientrega', 'abbreviation' => 'S'],
        ['name' => 'Tramaco', 'abbreviation' => 'TME']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->methods as $method){
            ShippingMethod::create($method);
        }
    }
}
