<?php

namespace App\Models\Clients;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receiver extends Model
{
    use HasFactory;

    protected $table = 'client_receivers';

    protected $fillable = [
        'names',
        'lastnames',
        'identity_card',
        'client_id'
    ];

    public $timestamps = false;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function completeName(): string
    {
        $result = $this->names . ' ' . $this->lastnames;
        return str_replace("'", "\\'", $result);
    }
}
