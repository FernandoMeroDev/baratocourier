<?php

namespace App\Permissions;

class Translator
{
    public static function role(string $role): string
    {
        return Data::$roleTranslations[$role];
    }
}