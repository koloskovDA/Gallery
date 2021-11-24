<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'FIO',
    ];

    public function file()
    {
        return $this->morphOne(File::class, 'file');
    }
}
