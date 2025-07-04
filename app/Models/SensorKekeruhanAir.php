<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorKekeruhanAir extends Model
{
    protected $table = 'sensor_kekeruhan_air';
    protected $fillable = [
        'nama_sensor',
        'kekeruhan_air',
        'waktu',
        'status',
    ];
}
