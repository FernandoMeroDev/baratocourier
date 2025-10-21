<?php

namespace App\Models\Packages;

use App\Models\Packages\Waybills\Waybill;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'tracking_number',
        'courier_name',
        'logo',
        'shipping_address',
        'reference',
        'guide_domain',
        'client_domain',
        'client_code',
        'shop_id',
        'package_category_id',
        'shipping_method_id',
        'user_id'
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'package_category_id', 'id');
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
