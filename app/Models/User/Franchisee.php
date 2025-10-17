<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Franchisee extends Model
{
    protected $fillable = [
        'phone_number',
        'courier_name',
        'logo',
        'address',
        'guide_domain',
        'client_domain',
        'user_id',
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
