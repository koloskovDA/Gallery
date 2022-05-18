<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = ['starts_at', 'ends_at'];

    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
