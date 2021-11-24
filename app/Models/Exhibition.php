<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exhibition extends Model
{
    use HasFactory;

    public function expositions() : HasMany
    {
        return $this->hasMany(Exposition::class);
    }

    public function auction() : HasOne
    {
        return $this->hasOne(Auction::class);
    }
}
