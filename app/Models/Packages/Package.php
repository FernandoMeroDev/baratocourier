<?php

namespace App\Models\Packages;

use App\Models\Packages\Waybills\Waybill;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'tracking_number',
        'courier_name',
        'logo',
        'shipping_address',
        'reference',
        'guide_domain',
        'client_domain',
        'client_code',
        'client_identity_card',
        'client_name',
        'client_lastname',
        'shop_id',
        'package_category_id',
        'shipping_method_id',
        'user_id'
    ];

    public static array $valid_statuses = [
        'eeuu_warehouse' => 'Bodega USA',
        'transit' => 'En Transito'
    ];

    public function decodeShippingAddress(): object
    {
        return json_decode($this->shipping_address);
    }

    public function client_complete_name(): string
    {
        return $this->client_name . ' ' . $this->client_lastname;
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'package_category_id');
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function waybills(): HasMany
    {
        return $this->hasMany(Waybill::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
