<?php

namespace App\Models\Packages\Waybills;

use App\Models\Packages\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Waybill extends Model
{
    protected $fillable = [
        'waybill_number',
        'price',
        'weight',
        'items_count',
        'description',
        'status',
        'package_id',
    ];

    public $timestamps = false;

    public function personalData(): HasOne
    {
        return $this->hasOne(PersonalData::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
