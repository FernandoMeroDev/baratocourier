<?php

namespace App\Models\Packages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'package_categories';

    public $timestamps = false;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'package_category_id');
    }
}
