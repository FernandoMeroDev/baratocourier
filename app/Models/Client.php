<?php

namespace App\Models;

use App\Models\Clients\FamilyCoreMember;
use App\Models\Clients\Receiver;
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
}
