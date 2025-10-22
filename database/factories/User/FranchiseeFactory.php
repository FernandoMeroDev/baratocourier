<?php

namespace Database\Factories\User;

use App\Models\User\Franchisee;
use Database\Factories\Traits\GenerateRandomNumber;
use Database\Seeders\Data\USAStates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Franchisee>
 */
class FranchiseeFactory extends Factory
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
            'phone_number' => '09' . $this->randomNumber(8),
            'courier_name' => 'Courier' . mb_strtoupper(fake()->randomLetter()),
            'logo' => 'example.webp',
            'address' => Franchisee::makeJSONAddress(
                fake()->sentence(),
                fake()->city(),
                fake()->randomElement(USAStates::$data),
                '13' . $this->randomNumber(3)
            ),
            'guide_domain' => 'BT' . mb_strtoupper(fake()->randomLetter()),
            'client_domain' => 'BT' . mb_strtoupper(fake()->randomLetter()),
            'waybill_text_reference' => '1 DE 1 MTC',
            'waybill_styles' => json_encode(Franchisee::defaultWaybillStyles()),
            // 'user_id' => null,
        ];
    }
}
