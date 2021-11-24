<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'role',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'role' => 'string',
    ];
}
