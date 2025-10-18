<?php

namespace Database\Factories;

use Database\Factories\Traits\GenerateRandomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    use GenerateRandomNumber;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::where('name', 'franchisee')->first();
        $users_ids = $role->users->pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'identity_card' => $this->randomNumber(10),
            'phone_number' => '09' . $this->randomNumber(8),
            'residential_address' => fake()->address(),
            'email' => fake()->email(),
            'user_id' => fake()->randomElement($users_ids)
        ];
    }
}
