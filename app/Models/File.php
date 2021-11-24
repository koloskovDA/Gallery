<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return MorphTo
     * @property int
     */

    public function file() : MorphTo
    {
        return $this->morphTo();
    }
}
