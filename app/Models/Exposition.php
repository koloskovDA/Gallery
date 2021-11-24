<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exposition extends Model
{
    use HasFactory;

    public function paintings() : HasMany
    {
        return $this->hasMany(Painting::class);
    }

    public function exhibition() : BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}
