<?php

namespace App\Models\Lands;

use App\Models\Packages\Waybills\Waybill;
use App\Models\traits\SequentialFormater;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Land extends Model
{
    use SequentialFormater;

    protected $fillable = [
        'status',
        'land_date',
        'user_id'
    ];

    public static array $valid_statuses = [
        'unlanded' => 'Sin Desembarcar', 
        'landed' => 'Desembarcado'
    ];

    public function readable_number()
    {
        return $this->user->franchisee->client_domain . $this->formatSequential($this->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function waybills(): HasMany
    {
        return $this->hasMany(Waybill::class);
    }
}
