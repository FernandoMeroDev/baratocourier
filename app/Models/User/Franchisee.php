<?php

namespace App\Models\User;

use App\Models\Packages\Waybills\Styles;
use App\Models\Packages\Waybills\TextStyles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franchisee extends Model
{
    use HasFactory;

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
        'waybill_styles',
        'user_id',
    ];

    public $timestamps = false;

    public static function calcWaybillNumber(Franchisee $franchisee): int
    {
        $current = $franchisee->next_waybill_number;
        $franchisee->next_waybill_number++;
        $franchisee->save();
        return $current;
    }

    public static function defaultWaybillStyles(): array
    {
        return [
            'logo' => (new Styles(1, 150, margin_top: 0))->buildArray(),
            'courier_name' => (new TextStyles(2, 20))->buildArray(),
            'address' => (new TextStyles(3, 10))->buildArray(),
            'phone_number' => (new TextStyles(4, 15))->buildArray(),
            'barcode' => (new TextStyles(5, 20))->buildArray(),
            'guide_domain' => (new TextStyles(6, 20, font_weight: 'bold'))->buildArray(),
            'waybill_number' => (new TextStyles(7, 20, font_weight: 'bold'))->buildArray(),
            'waybill_text_reference' => (new TextStyles(8, 15))->buildArray(),
            'weight' => (new TextStyles(9, 20, font_weight: 'bold'))->buildArray(),
            'created_at' => (new TextStyles(10, 10))->buildArray(),
            'tracking_number' => (new TextStyles(11, 10))->buildArray(),
            'reference' => (new TextStyles(12, 15))->buildArray(),
            'category' => (new TextStyles(13, 15))->buildArray(),
            'shipping_address' => (new TextStyles(14, 15, font_weight: 'bold'))->buildArray(),
            'shipping_method' => (new TextStyles(15, 20, font_weight: 'bold'))->buildArray(),
            'client_code' => (new TextStyles(16, 20, font_weight: 'bold'))->buildArray(),
            'client_name' => (new TextStyles(17, 15))->buildArray(),
        ];
    }

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
