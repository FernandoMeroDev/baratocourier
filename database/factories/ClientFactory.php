<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = Role::where('name', 'franchisee')->first();
        return [
            'name' => fake()->name(),
            'identity_card' => $this->randomNumber(10),
            'phone_number' => '09' . $this->randomNumber(8),
            'residential_address' => fake()->address(),
            'email' => fake()->email(),
            'user_id' => $user->id
        ];
    }

    private function randomNumber(int $n_digits): string
    {
        $number = '';
        for($i = 0; $i < $n_digits; $i++)
            $number .= fake()->randomDigit();
        return $number;
    }
}
