<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franchisee extends Model
{
    protected $table = 'franchisees';

    protected $fillable = [
        'phone_number',
        'courier_name',
        'logo',
        'address',
        'guide_domain',
        'client_domain',
        'next_waybill_number',
        'waybill_text_reference',
        'user_id',
    ];

    public $timestamps = false;

    public static function makeJSONAddress(
        $line_1, $city_name, $province_name, $zip_code
    ): string
    {
        return json_encode([
            'line_1' => $line_1,
            'city_name' => $city_name,
            'province_name' => $province_name,
            'zip_code' => $zip_code,
        ]);
    }

    public function readable_address(): string
    {
        $address = json_decode($this->address);
        return $address->line_1 
            . ', ' . $address->city_name
            . ', ' . $address->province_name
            . ', zip: ' . $address->zip_code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
