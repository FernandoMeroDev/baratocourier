<?php

namespace App\Models\Packages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'abbreviation'
    ];

    public $timestamps = false;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
