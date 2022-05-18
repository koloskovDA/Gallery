<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory;

    public function file()
    {
        return $this->morphOne(File::class, 'file');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function author()
    {
        return $this->belongsto(Author::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function exposition()
    {
        return $this->belongsTo(Exposition::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
