<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingTarget extends Model
{
    use HasFactory;

    protected $table = 'shipping_targets';

    protected $fillable = [
        'name',
        'lastname',
        'identity_card',
        'phone_number',
        'shipping_address_id'
    ];

    public $timestamps = false;

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }
}
