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

    public static function buildJSONAddress(
        $line_1,
        $line_2,
        $city_name,
        $province_name,
        $zip_code,
        $target_name,
        $target_lastname,
        $target_identity_card,
        $target_phone_number
    ): string
    {
        return json_encode([
            'line_1' => $line_1,
            'line_2' => $line_2,
            'city_name' => $city_name,
            'province_name' => $province_name,
            'zip_code' => $zip_code,
            'target' => [
                'name' => $target_name,
                'lastname' => $target_lastname,
                'identity_card' => $target_identity_card,
                'phone_number' => $target_phone_number
            ]
        ]);
    }

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

    public function jsonAddress(): string
    {
        return json_encode([
            'line_1' => $this->line_1,
            'line_2' => $this->line_2,
            'city_name' => $this->city_name,
            'province_name' => $this->province->name,
            'zip_code' => $this->zip_code,
            'target' => [
                'name' => $this->target->name,
                'lastname' => $this->target->lastname,
                'identity_card' => $this->target->identity_card,
                'phone_number' => $this->target->phone_number
            ]
        ]);
    }
}