<?php

namespace Database\Factories\Traits;

trait GenerateRandomNumber
{
    protected function randomNumber(int $n_digits): string
    {
        $number = '';
        for($i = 0; $i < $n_digits; $i++)
            $number .= fake()->randomDigit();
        return $number;
    }
}