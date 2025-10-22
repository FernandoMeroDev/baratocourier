<?php

namespace App\Models\Shipments;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'shipment_datetime',
        'upshipment_datetime',
        'status',
        'arrival_min_date',
        'arrival_max_date',
        'shipment_type_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ShipmentType::class);
    }

    public function bags(): HasMany
    {
        return $this->hasMany(ShippingBag::class);
    }
}
