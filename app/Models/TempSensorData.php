<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempSensorData extends Model
{
    use HasFactory;

    protected $table = 'temp_sensor_data';

    protected $fillable = [
        'humidity',
        'temperature_celsius',
        'temperature_fahrenheit',
        'heat_index_celsius',
        'heat_index_fahrenheit'
    ];
}