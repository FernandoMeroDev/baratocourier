<?php

namespace App\Models\Packages\Waybills;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalData extends Model
{
    protected $table = 'waybills_personal_data';

    protected $fillable = [
        'name',
        'lastname',
        'identity_card',
        'phone_number',
        'person_type',
        'waybill_id'
    ];

    public $timestamps = false;

    public function waybill(): BelongsTo
    {
        return $this->belongsTo(Waybill::class);
    }
}
