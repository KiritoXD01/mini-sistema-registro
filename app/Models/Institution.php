<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = "institutions";
    protected $fillable = [
        'name', 'phone', 'email', 'code',
        'address', 'image'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
