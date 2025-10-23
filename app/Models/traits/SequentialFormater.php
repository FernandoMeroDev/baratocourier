<?php

namespace App\Models\traits;

trait SequentialFormater
{
    public function formatSequential(int $number, int $padding = 6): string 
    {
        return mb_str_pad((string) $number, $padding, '0', STR_PAD_LEFT);
    }
}