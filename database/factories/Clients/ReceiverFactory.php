<?php

namespace Database\Factories\Clients;

use Database\Factories\Traits\GenerateRandomNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients\Receiver>
 */
class ReceiverFactory extends Factory
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
            'identity_card' => 13 . $this->randomNumber(8),
            // 'client_id' => null
        ];
    }
}
