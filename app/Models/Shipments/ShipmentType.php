<?php

namespace App\Models\Shipments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentType extends Model
{
    public $timestamps = false;

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
