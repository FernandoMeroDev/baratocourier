<?php

namespace App\Models;

use App\Models\Clients\FamilyCoreMember;
use App\Models\Clients\Receiver;
use App\Models\Clients\ShippingAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'lastname',
        'identity_card',
        'phone_number',
        'residential_address',
        'email',
        'user_id'
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function familyCoreMembers(): HasMany
    {
        return $this->hasMany(FamilyCoreMember::class);
    }

    public function receivers(): HasMany
    {
        return $this->hasMany(Receiver::class);
    }

    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
