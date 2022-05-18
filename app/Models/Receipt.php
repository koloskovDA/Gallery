<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Receipt extends Model
{
    use HasFactory;

    public function ticket() : BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function file() : MorphOne
    {
        return $this->morphOne(File::class, 'file');
    }
}
