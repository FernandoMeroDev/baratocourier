<?php

namespace App\Models\Shipments;

use App\Models\Packages\Waybills\Waybill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingBag extends Model
{
    public $timestamps = false;

    protected $fillable = ['number'];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function waybills(): HasMany
    {
        return $this->hasMany(Waybill::class);
    }
}
