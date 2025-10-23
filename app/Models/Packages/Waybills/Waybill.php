<?php

namespace App\Models\Packages\Waybills;

use App\Models\Packages\Package;
use App\Models\Shipments\ShippingBag;
use App\Models\traits\SequentialFormater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Waybill extends Model
{
    use HasFactory, SequentialFormater;

    protected $fillable = [
        'waybill_number',
        'price',
        'weight',
        'items_count',
        'description',
        'package_id',
        'shipping_bag_id'
    ];

    public $timestamps = false;

    public function readable_number(): string
    {
        return $this->package->guide_domain . $this->formatSequential($this->waybill_number);
    }

    public function personalData(): HasOne
    {
        return $this->hasOne(PersonalData::class, 'waybill_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function shippingBag(): BelongsTo
    {
        return $this->belongsTo(ShippingBag::class);
    }
}
