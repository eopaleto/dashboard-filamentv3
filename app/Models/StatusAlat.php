<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusAlat extends Model
{
    protected $table = 'status_alat';
    protected $fillable = [
        'nama_alat',
        'status',
    ];
}
