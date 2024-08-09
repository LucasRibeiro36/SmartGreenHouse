<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilSensorData extends Model
{
    use HasFactory;

    protected $table = 'Soil_sensor_data';

    protected $fillable = [
        'moisture',
    ];
}
