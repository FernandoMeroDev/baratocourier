<?php

namespace Database\Factories\Clients;

use Database\Factories\Traits\GenerateRandomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients\FamilyCoreMember>
 */
class FamilyCoreMemberFactory extends Factory
{
    use GenerateRandomNumber;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => fake()->name(),
            'lastnames' => fake()->lastName(),
            'identity_card' => $this->randomNumber(10),
            // 'client_id' => null
        ];
    }
}
