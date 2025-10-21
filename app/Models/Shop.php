<?php

namespace App\Models;

use App\Models\Packages\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
