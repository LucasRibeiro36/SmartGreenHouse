<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('temp_sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('humidity');
            $table->float('temperature_celsius');
            $table->float('temperature_fahrenheit');
            $table->float('heat_index_celsius');
            $table->float('heat_index_fahrenheit');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_sensor_data');
    }
};
