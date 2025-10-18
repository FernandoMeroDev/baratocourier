<?php

namespace App\Models;

use App\Models\Clients\ShippingAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
