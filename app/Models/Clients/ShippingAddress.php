<?php

namespace App\Models\Clients;

use App\Models\Client;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shipping_addresses';

    protected $fillable = [
        'line_1',
        'line_2',
        'city_name',
        'zip_code',
        'province_id',
        'client_id'
    ];

    public $timestamps = false;

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function target(): HasOne
    {
        return $this->hasOne(ShippingTarget::class);
    }

    public function completeAddress(): string
    {
        $result = $this->line_1
            . ', ' . $this->line_2
            . ', ' . $this->city_name
            . ', ' . $this->province->name
            . ', Código: ' . $this->zip_code . '.';
        return str_replace("'", "\\'", $result);
    }
}