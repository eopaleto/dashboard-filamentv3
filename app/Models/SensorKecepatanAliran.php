<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorKecepatanAliran extends Model
{
    protected $table = 'sensor_kecepatan_aliran';
    protected $fillable = [
        'nama_sensor',
        'kecepatan_aliran',
        'waktu',
        'status',
    ];
}
